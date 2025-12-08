<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDocument;

class DocumentoController extends Controller
{
    // Mostrar formulario, si viene código en URL, buscar documento
    public function validarForm($code = null)
    {
        $document = null;

        if ($code) {
            $document = UserDocument::where('code', $code)->first();
        }

        return view('validar-documento', compact('document', 'code'));
    }

    // Procesar formulario POST
    public function validar(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = $request->code;

        // Redirigir a la URL con el código en la ruta
        return redirect()->route('validar.documento', ['code' => $code]);
    }
}
