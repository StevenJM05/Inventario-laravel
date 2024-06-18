<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\ComprasItem;
use App\Models\Kardex;
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
            $compraItem= ComprasItem::create([
                'compra_id' => $compra->id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio'],
                'total' => $producto['cantidad'] * $producto['precio']
            ]);
            // Actualizar el kardex
            $this->actualizarKardex($compraItem, 'entrada');
        }

        return redirect()->route('compras.create')->with('success', 'Compra creada exitosamente'); 
    }

    // Método para actualizar el kardex
    private function actualizarKardex(ComprasItem $compraItem, $tipoMovimiento)
    {
        $producto = Producto::findOrFail($compraItem->producto_id);
        $stockAnterior = $producto->stock;
        $stockActual = $tipoMovimiento == 'entrada' ? $stockAnterior + $compraItem->cantidad : $stockAnterior - $compraItem->cantidad;

        // Actualizar el stock del producto
        $producto->stock = $stockActual;
        $producto->save();

        // Crear el registro en el kardex
        Kardex::create([
            'producto_id' => $compraItem->producto_id,
            'transaccionable_id' => $compraItem->id,
            'transaccionable_type' => ComprasItem::class,
            'cantidad' => $compraItem->cantidad,
            'precio_unitario' => $compraItem->precio_unitario,
            'total' => $compraItem->total,
            'tipo_movimiento' => $tipoMovimiento,
            'stock_anterior' => $stockAnterior,
            'stock_actual' => $stockActual,
            'fecha' => now(),
        ]);
    }
}

