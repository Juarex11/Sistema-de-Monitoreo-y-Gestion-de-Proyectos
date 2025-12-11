<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ClienteController;
/*
|--------------------------------------------------------------------------
| PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página principal
Route::get('/', function () {
    return view('home');
})->name('home');

// Login
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Validación pública de documentos
Route::get('/validar-documento/{code?}', [DocumentoController::class, 'validarForm'])
    ->name('validar.documento');

Route::post('/validar-documento', [DocumentoController::class, 'validar'])
    ->name('validar.documento.post');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Crear usuario (solo crear, no administrar)
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');


    /*
    |--------------------------------------------------------------------------
    | SOLO ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        /* --------------------------- USUARIOS --------------------------- */

        // Lista
        Route::get('/usuarios', [UserAdminController::class, 'index'])->name('usuarios.index');

        // Ver info
        Route::get('/usuarios/{id}/info', [UserAdminController::class, 'info'])->name('usuarios.info');

        // Actualizar
        Route::put('/usuarios/{id}/actualizar', [UserAdminController::class, 'update'])->name('usuarios.update');

        // Eliminar
        Route::get('/usuarios/{id}/eliminar', [UserAdminController::class, 'eliminar'])->name('usuarios.eliminar');

        // Verificar email
        Route::post('/usuarios/check-email', [UserAdminController::class, 'checkEmail'])->name('usuarios.check-email');


        /* --------------------------- DOCUMENTOS --------------------------- */

        Route::post('/generar-qr', [UserDocumentController::class, 'generarQr'])->name('generar.qr');

        Route::post('/usuarios/documentos', [UserDocumentController::class, 'store'])
            ->name('usuarios.documentos.store');

        Route::delete('/usuarios/documentos/{document}', [UserDocumentController::class, 'destroy'])
            ->name('usuarios.documentos.destroy');


        /* --------------------------- TAREAS --------------------------- */

        Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
        Route::put('/tareas/{id}/estado', [TareaController::class, 'updateEstado'])->name('tareas.updateEstado');
        Route::put('/tareas/{id}', [TareaController::class, 'update'])->name('tareas.update');
        Route::delete('/tareas/{id}', [TareaController::class, 'destroy'])->name('tareas.destroy');


        /* --------------------------- PROYECTOS --------------------------- */

        Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
        Route::get('/proyectos/crear', [ProjectController::class, 'create'])->name('proyectos.create');
        Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store');

        Route::get('/proyectos/{id}/data', [ProjectController::class, 'showData'])
            ->name('proyectos.data');

        Route::put('/proyectos/{id}', [ProjectController::class, 'update'])
            ->name('proyectos.update');

        Route::delete('/proyectos/{proyecto}', [ProjectController::class, 'destroy'])
            ->name('proyectos.destroy');


        /* --------------------------- PRESUPUESTOS --------------------------- */

        Route::post('/presupuestos', [PresupuestoController::class, 'store'])
            ->name('presupuestos.store');

        Route::delete('/presupuestos/{id}', [PresupuestoController::class, 'destroy'])
            ->name('presupuestos.destroy');


            /* --------------------------- CLIENTES --------------------------- */

        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/crear', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

        Route::get('/clientes/{id}/editar', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');

        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');


    });
});
