<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'DESC')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

public function store(Request $request)
{
    // Generar código único (por ejemplo: CLI-0001, CLI-0002, etc.)
    $ultimo = Cliente::latest('id')->first();
    $numero = $ultimo ? $ultimo->id + 1 : 1;
    $codigo = 'CLI-' . str_pad($numero, 4, '0', STR_PAD_LEFT);

    Cliente::create([
        'codigo' => $codigo,
        'tipo_cliente' => $request->tipo_cliente,
        'nombre_comercial' => $request->nombre_comercial,
        'razon_social' => $request->razon_social,
        'ruc_dni' => $request->ruc_dni,
        'representante' => $request->representante,
        'telefono' => $request->telefono,
        'telefono_alt' => $request->telefono_alt,
        'email' => $request->email,
        'email_alt' => $request->email_alt,
        'direccion' => $request->direccion,
        'ciudad' => $request->ciudad,
        'pais' => $request->pais,
        'actividad' => $request->actividad,
        'estado_cliente' => $request->estado_cliente,
        'creado_por' => Auth::id(),
        'actualizado_por' => Auth::id(),
    ]);

    return redirect()->route('clientes.index')
                     ->with('success', 'Cliente registrado correctamente');
}


    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->update([
            ...$request->all(),
            'actualizado_por' => Auth::id(),
        ]);

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente eliminado');
    }
}
