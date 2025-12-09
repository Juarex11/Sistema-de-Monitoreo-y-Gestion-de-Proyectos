<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProjectController;
// Página principal
Route::get('/', function () {
    return view('home');
})->name('home');

// LOGIN
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// Mostrar formulario de validación (público)
Route::get('/validar-documento/{code?}', [DocumentoController::class, 'validarForm'])
    ->name('validar.documento');

// Procesar validación por POST (formulario)
Route::post('/validar-documento', [DocumentoController::class, 'validar'])
    ->name('validar.documento.post');


// RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');


    // SOLO ADMIN
    Route::middleware(['auth', 'admin'])->group(function () {

            // LISTA DE USUARIOS
            Route::get('/usuarios', [UserAdminController::class, 'index'])->name('usuarios.index');
            
            // CREAR USUARIO
 Route::post('/generar-qr', [UserDocumentController::class, 'generarQr'])->name('generar.qr');
              Route::post('/usuarios/documentos', [UserDocumentController::class, 'store'])->name('usuarios.documentos.store');
    Route::delete('/usuarios/documentos/{document}', [UserDocumentController::class, 'destroy'])->name('usuarios.documentos.destroy');
    
            // VER INFORMACIÓN
            Route::get('/usuarios/{id}/info', [UserAdminController::class, 'info'])->name('usuarios.info');
            
            // ACTUALIZAR USUARIO
            Route::put('/usuarios/{id}/actualizar', [UserAdminController::class, 'update'])->name('usuarios.update');
            
            // ELIMINAR USUARIO
            Route::get('/usuarios/{id}/eliminar', [UserAdminController::class, 'eliminar'])->name('usuarios.eliminar');

            // VERIFICAR EMAIL (AJAX)
            Route::post('/usuarios/check-email', [UserAdminController::class, 'checkEmail'])->name('usuarios.check-email');


            Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
    Route::get('/proyectos/crear', [ProjectController::class, 'create'])->name('proyectos.create');
    Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store');
    // Eliminar proyecto
Route::delete('/proyectos/{proyecto}', [ProjectController::class, 'destroy'])
    ->name('proyectos.destroy');
});

});