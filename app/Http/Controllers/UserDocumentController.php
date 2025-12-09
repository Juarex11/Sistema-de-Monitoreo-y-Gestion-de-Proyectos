<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserDocumentController extends Controller
{
    // Subir documento
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required|string|max:255',
                'file' => 'required|mimes:pdf|max:5120',
                'date' => 'required|date',
                'code' => 'required|string|max:50',
            ]);

            $filePath = $request->file('file')->store('documents', 'public');

            $document = UserDocument::create([
                'user_id' => $request->user_id,
                'name' => $request->name,
                'code' => $request->code,
                'file' => $filePath,
                'date' => $request->date,
                'uploaded_by' => Auth::user()->name,
            ]);

            return back()->with('success', 'Documento subido correctamente.');
            
        } catch (\Exception $e) {
            Log::error('Error al subir documento: ' . $e->getMessage());
            return back()->with('error', 'Error al subir el documento: ' . $e->getMessage());
        }
    }

    // Generar QR usando QuickChart.io API
    public function generarQr(Request $request)
    {
        try {
            // Validar request
            $request->validate([
                'code' => 'required|string'
            ]);

            // Generar URL completa para validación
            $url = url('/validar-documento/' . $request->code);

            // Generar QR usando QuickChart.io
            $qrApiUrl = 'https://quickchart.io/qr?text=' . urlencode($url) . '&size=300&margin=2';
            
            // Obtener la imagen del QR
            $qrImage = @file_get_contents($qrApiUrl);
            
            if ($qrImage === false) {
                throw new \Exception('No se pudo generar el código QR. Verifica tu conexión a internet.');
            }

            // Convertir a base64
            $qrBase64 = base64_encode($qrImage);

            return response()->json([
                'success' => true,
                'url' => $url,
                'qr' => $qrBase64,
                'qrApiUrl' => $qrApiUrl, // URL directa para preview
            ]);

        } catch (\Exception $e) {
            Log::error('Error al generar QR: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'error' => 'Error al generar el código QR',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function index($userId)
    {
        $documents = UserDocument::where('user_id', $userId)->get();
        return view('documents.index', compact('documents'));
    }

    public function destroy(UserDocument $document)
    {
        try {
            Storage::disk('public')->delete($document->file);
            $document->delete();

            return back()->with('success', 'Documento eliminado correctamente.');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el documento.');
        }
    }

    public function show(UserDocument $document)
    {
        if (!Storage::disk('public')->exists($document->file)) {
            return back()->with('error', 'Archivo no encontrado.');
        }

        return response()->file(storage_path('app/public/' . $document->file));
    }
}