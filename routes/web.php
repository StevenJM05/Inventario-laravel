<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');

// Ruta para manejar la solicitud POST del login
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Rutas adicionales
Route::view('/registro', 'register')->name('registro');
Route::view('/menu', 'menu')->middleware('auth')->name('menu');

Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::get('/cerrar-sesion', [LoginController::class, 'logout'])->name('logout');
