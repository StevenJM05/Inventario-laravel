<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ImpuestosController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Models\UnidadMedida;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Rutas del Login 
Route::view('/login', 'login')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::view('/menu', 'menu')->middleware('auth')->name('menu');
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
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
Route::get('ventas/create', [VentaController::class, 'create'])->middleware('auth')->name('ventas.create');
Route::post('/ventas', [VentaController::class, 'store'])->middleware('auth')->name('ventas.store');
Route::get('ventas/{id}', [VentaController::class, 'show'])->name('ventas.show');

//Factura
Route::get('/ventas/{id}/factura', [VentaController::class, 'generarFacturaPDF'])->name('ventas.factura.pdf');

//Rutas de usuario
Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/Usuario/{id}', [UserController::class, 'destroy'])->name('users.destroy');

//Ruta para compras
Route::get('/compras', [CompraController::class, 'index'])->name('compras.index');
Route::get('compras/create',[CompraController::class, 'create'])->middleware('auth')->name('compras.create');
Route::post('/compras', [CompraController::class, 'store'])->middleware('auth')->name('compras.store');

//Kardex
Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');



