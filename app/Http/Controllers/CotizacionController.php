<?php


// ============================================
// app/Http/Controllers/CotizacionController.php
// ============================================

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('cliente')->orderBy('created_at', 'desc')->get();
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('cotizaciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'descripcion' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.titulo' => 'required|string',
            'items.*.precio' => 'required|numeric|min:0',
            'items.*.periodicidad' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Crear la cotización
            $cotizacion = Cotizacion::create([
                'codigo' => 'COT-' . date('Ymd') . '-' . time(),
                'cliente_id' => $request->cliente_id,
                'descripcion' => $request->descripcion,
                'estado' => 'pendiente',
                'total' => 0
            ]);

            $total = 0;

            // Crear los items
            foreach ($request->items as $item) {
                $precioBase = (float) $item['precio'];
                $aplicaIgv = isset($item['igv']) && $item['igv'] ? 1 : 0;
                $precioTotal = $aplicaIgv ? ($precioBase * 1.18) : $precioBase;

                // IMPORTANTE: Usar los nombres correctos de campos
                $cotizacion->items()->create([
                    'titulo' => $item['titulo'],
                    'descripcion' => $item['descripcion'] ?? null,
                    'precio' => $precioBase,
                    'tipo_pago' => $item['periodicidad'],  // ← tipo_pago en vez de periodicidad
                    'aplica_igv' => $aplicaIgv,            // ← aplica_igv en vez de igv
                    'total' => $precioTotal
                ]);

                $total += $precioTotal;
            }

            // Actualizar el total
            $cotizacion->update(['total' => $total]);

            DB::commit();

            return redirect()
                ->route('cotizaciones.index')
                ->with('success', 'Cotización creada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('error', 'Error al crear la cotización: ' . $e->getMessage());
        }
    }

  public function show($id)
{
    $cotizacion = Cotizacion::with('cliente', 'items')->findOrFail($id);

    return view('cotizaciones.show', compact('cotizacion'));
}

public function destroy($id)
{
    $cotizacion = Cotizacion::findOrFail($id);
    $cotizacion->delete();

    return redirect()->route('cotizaciones.index')
                     ->with('success', 'Cotización eliminada correctamente');
}
public function updateItem(Request $request, $id)
{
    $item = \App\Models\CotizacionItem::findOrFail($id);

    $item->titulo = $request->titulo;
    $item->descripcion = $request->descripcion;
    $item->tipo_pago = $request->tipo_pago;
    $item->precio = $request->precio;
    $item->aplica_igv = $request->has('aplica_igv') ? 1 : 0;

    // Recalcular total
    $item->total = $request->precio * ($item->aplica_igv ? 1.18 : 1);

    $item->save();

    // Recalcular total general de la cotización
    $cotizacion = $item->cotizacion;
    $cotizacion->total = $cotizacion->items->sum('total');
    $cotizacion->save();

    return back()->with('success', 'Ítem actualizado correctamente.');
}
public function deleteItem($id)
{
    $item = \App\Models\CotizacionItem::findOrFail($id);

    $cotizacion = $item->cotizacion;

    $item->delete();

    // Recalcular nuevo total de la cotización
    $cotizacion->total = $cotizacion->items->sum('total');
    $cotizacion->save();

    return back()->with('success', 'Ítem eliminado correctamente.');
}
public function agregarItem(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string',
        'descripcion' => 'required|string',
        'cantidad' => 'required|numeric|min:1',
        'precio' => 'required|numeric|min:0',
        'tipo_pago' => 'required|string',
        'aplica_igv' => 'required|boolean',
    ]);

    $cotizacion = Cotizacion::findOrFail($id);

    $subtotal = $request->cantidad * $request->precio;
    $total = $request->aplica_igv ? $subtotal * 1.18 : $subtotal;

    $cotizacion->items()->create([
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'cantidad' => $request->cantidad,
        'precio' => $request->precio,
        'tipo_pago' => $request->tipo_pago,
        'aplica_igv' => $request->aplica_igv,
        'total' => $total,
    ]);

    // Actualizar total general
    $cotizacion->total = $cotizacion->items->sum('total');
    $cotizacion->save();

    return back()->with('success', 'Item agregado correctamente.');
}


    public function updateEstado(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,aprobada,rechazada',
        ]);

        $cotizacion->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado');
    }

    public function exportPdf(Cotizacion $cotizacion)
    {
        $cotizacion->load('cliente', 'items');
        $pdf = Pdf::loadView('cotizaciones.pdf', compact('cotizacion'));
        return $pdf->download($cotizacion->codigo . '.pdf');
    }
}