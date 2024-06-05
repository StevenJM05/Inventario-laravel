<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ImpuestosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\VentaController;
use App\Models\UnidadMedida;
use Illuminate\Support\Facades\Auth;
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

//Rutas de marca
Route::get('/marcas', [MarcaController::class, 'index'])->name('marcas.index');
Route::post('/marcas', [MarcaController::class, 'store'])->name('marcas.store');
Route::put('/marcas/{id}', [MarcaController::class, 'update'])->name('marcas.update');
Route::delete('/marcas/{id}', [MarcaController::class, 'destroy'])->name('marcas.destroy');

//Rutas de producto
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::get('search-products', [ProductoController::class, 'search'])->name('search-products');

// Rutas para unidades de medida
Route::get('/unidadesMedida', [UnidadMedidaController::class, 'index'])->name('unidadesMedida.index');
Route::post('/unidadesMedida', [UnidadMedidaController::class, 'store'])->name('unidadesMedida.store');
Route::put('/unidadesMedida/{id}', [UnidadMedidaController::class, 'update'])->name('unidadesMedida.update');
Route::delete('/unidadesMedida/{id}', [UnidadMedidaController::class, 'update'])->name('unidadesMedida.destroy');

//Rutas para impuestos
Route::get('/impuestos', [ImpuestosController::class, 'index'])->name('impuestos.index');
Route::post('/impuestos', [ImpuestosController::class, 'store'])->name('impuestos.store');
Route::put('/impuestos/{id}', [ImpuestosController::class, 'update'])->name('impuestos.update');
Route::delete('/impuestos/{id}', [ImpuestosController::class, 'destroy'])->name('impuestos.destroy');

//Rutas para ventas
Route::get('ventas/create', [VentaController::class, 'create'])->middleware('auth')->name('ventas.create');
Route::post('ventas', [VentaController::class, 'store'])->middleware('auth')->name('ventas.store');
