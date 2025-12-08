<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;

class UserDocumentController extends Controller
{
    // Subir documento
public function store(Request $request)
{
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

    // Generar QR con URL (usando GD por defecto)
    $url = route('validar.documento', $document->code);
$qr = new Generator();
$qr->setBackend(new \SimpleSoftwareIO\QrCode\Renderer\Image\SvgImageBackEnd());

    // Retornar con QR para mostrar en blade
    return back()
        ->with('success', 'Documento subido correctamente.')
        ->with('qr', $qrImage)
        ->with('code', $document->code);

    return back()->with('success', 'Documento subido correctamente.');
}


    // Función generadora de códigos
    private function generateRandomCode($length = 10)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomCode;
    }

    public function index($userId)
    {
        $documents = UserDocument::where('user_id', $userId)->get();
        return view('documents.index', compact('documents'));
    }

    public function destroy(UserDocument $document)
    {
        Storage::disk('public')->delete($document->file);
        $document->delete();

        return back()->with('success', 'Documento eliminado correctamente.');
    }

    public function show(UserDocument $document)
    {
        if (!Storage::disk('public')->exists($document->file)) {
            return back()->with('error', 'Archivo no encontrado.');
        }

        return response()->file(storage_path('app/public/' . $document->file));
    }
}
