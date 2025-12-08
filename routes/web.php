<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\DashboardController;
// Página principal
Route::get('/', function () {
    return view('home');
});

// LOGIN
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// RUTAS PROTEGIDAS
Route::middleware('auth')->group(function () {

    // DASHBOARD
 Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


    // SOLO ADMIN
    Route::middleware('admin')->group(function () {

        // USUARIOS (administración)
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');

        // CRUD avanzado (si piensas usarlo luego)
        Route::get('/admin/usuarios', [UserAdminController::class, 'index'])->name('admin.usuarios');
       
        Route::put('/admin/usuarios/{id}/actualizar', [UserAdminController::class, 'update'])
    ->name('admin.usuarios.update');

        Route::get('/admin/usuarios/{id}/eliminar', [UserAdminController::class, 'delete'])->name('admin.usuarios.eliminar');
        Route::get('/admin/usuarios/{id}/info', [UserAdminController::class, 'info'])->name('admin.usuarios.info');
    });

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
