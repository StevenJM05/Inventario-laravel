<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

//Rutas del Login 
Route::view('/', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::view('/registro', 'register')->name('registro');
Route::view('/menu', 'menu')->middleware('auth')->name('menu');
Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::get('/cerrar-sesion', [LoginController::class, 'logout'])->name('logout');

//Rutas de categoria
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
