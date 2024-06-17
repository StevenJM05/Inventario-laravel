<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ComprasItem;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('compras_items.producto')->paginate(10);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('compras.nueva_compra', compact('productos'));
    }

    public function store(Request $request)
    {
       
        // Validar la solicitud
        $request->validate(
            [
                'compras_items' => 'required|array',
                'compras_items.*.producto_id' => 'required|exists:productos,id',
                'compras_items.*.cantidad' => 'required|integer|min:1',
                'compras_items.*.precio' => 'required|numeric|min:0',
            ]
        );

        //Calcular Totales
        $subtotal = 0;
        $productos = $request->input('compras_items');

        foreach ($productos as $producto) {
            $subtotal += $producto['cantidad'] * $producto['precio'];
        }

        //calcular descuento si lo hay
        $descuento = $request->has('descuento') ? ($request->input('tipoDescuento') == 1 ? ($subtotal * $request->input('descuento') / 100) : $request->input('descuento')) : 0;

        //calcular total
        $total = $subtotal - $descuento;

        //Si no hay descuento se le asigna el valor de 0
        $descuentoTotal = $request->has('descuento') ? $descuento : 0;

        //creamos la compra
        $compra = Compra::create([
            'cantidad' => count($productos),
            'subtotal' => $subtotal,
            'descuento' => $descuentoTotal,
            'total' => $total,
        ]);

        //creamos los items de la compra
        foreach ($productos as $producto) {
            ComprasItem::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio' => $producto['precio'],
                'total' => $producto['cantidad'] * $producto['precio']
            ]);
        }
    }
}
