<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentasItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function create(){
        return view('ventas.addsale');
    }

    public function store(Request $request)
    {
        // Valida la solicitud
        $request->validate([
            'cliente' => 'required|string|max:255',
            'descuento' => 'required|numeric|min:0',
            'tipoDescuento' => 'required|in:0,1',
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
            'productos.*.impuesto' => 'required|numeric|min:0'
        ]);

        // Calcular totales
        $subtotal = 0;
        $total_impuestos = 0;
        $productos = $request->input('productos');

        foreach ($productos as $producto) {
            $subtotal += $producto['cantidad'] * $producto['precio'];
            $total_impuestos += $producto['cantidad'] * $producto['precio'] * ($producto['impuesto'] / 100);
        }

        $descuento = $request->input('tipoDescuento') == 1 ? ($subtotal * $request->input('descuento') / 100) : $request->input('descuento');
        $total = $subtotal + $total_impuestos - $descuento;

        // Crear la venta
        $venta = Venta::create([
            'usuario_id' => Auth::id(),
            'cantidad_total' => count($productos),
            'subtotal' => $subtotal,
            'descuentos_totales' => $descuento,
            'total_impuestos' => $total_impuestos,
            'total' => $total,
        ]);

        // Crear los elementos de la venta
        foreach ($productos as $producto) {
            VentasItem::create([
                'venta_id' => $venta->id,
                'producto_id' => $producto['producto_id'],
                'cantidad' => $producto['cantidad'],
                'precio_unidad' => $producto['precio'],
                'impuesto' => $producto['impuesto'],
                'total' => $producto['cantidad'] * $producto['precio'] * (1 + $producto['impuesto'] / 100)
            ]);
        }


        // Crear la factura
        Factura::create([
            'fecha' => now(),
            'cliente' => $request->input('cliente'),
            'numero_factura'=> $this->generateCodeFact($venta->id, Auth::id()),
            'total' => $subtotal,
            'impuesto' => $total_impuestos,
            'total_con_impuesto' => $total,
            'ventas_id' => $venta->id,
        ]);

        return redirect()->route('ventas.create')->with('success', 'Venta creada exitosamente.');
    }

    private function generateCodeFact(int $id_venta, int $id_usuario):string{
        $current_date = now();
        //Fomatear la fecha
        $fecha = $current_date->format('Ymd');
        return $id_venta.''.$id_usuario.''.$fecha;
    }
}
