<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;


Route::get('/', [UsuarioController::class, 'base']);

Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');

Route::post('/usuario/login', [UsuarioController::class, 'login'])->name('usuario.login');

Route::get('/usuario/logout', [UsuarioController::class, 'logout'])->name('usuario.logout');

Route::put('/usuario/verify', [UsuarioController::class, 'verify'])->name('usuario.verify');

Route::get('/usuario/create', [UsuarioController::class, 'create'])->name('usuario.create');

Route::post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store');

Route::get('/usuario/{id}/edit', [UsuarioController::class, 'edit'])->name('usuario.edit');

Route::put('/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');

Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

