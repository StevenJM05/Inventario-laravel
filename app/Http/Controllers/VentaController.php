<?php
namespace App\Http\Controllers;

use App\Http\Resources\VentasItemsResource;
use App\Models\Factura;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use App\Models\VentasItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{

    public function index()
    {
        $ventas = Venta::with('user')->paginate(7);
        $users = User::all();
        $productos = Producto::all();
        return view('ventas.index', compact('ventas', 'users', 'productos'));
    }

    //Metodo para mostrar los productos de la venta
    public function show($id)
    {
        $ventas_items = VentasItem::where('venta_id', $id)->get();
        return response()->json(VentasItemsResource::collection($ventas_items));
    }

    //Metodo para retornar la vista para hacer ventas
    public function create()
    {
        return view('ventas.addsale');
    }

    //Metodo para crear una venta
    public function store(Request $request)
    {
        dd($request->all());
        // Validar la solicitud
        $request->validate([
            'cliente' => 'required|string|max:255',
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

        // Calcular descuento
        $descuento = $request->has('descuento') ? ($request->input('tipoDescuento') == 1 ? ($subtotal * $request->input('descuento') / 100) : $request->input('descuento')) : 0;

        // Calcular total
        $total = $subtotal + $total_impuestos - $descuento;

        // Asignar un valor predeterminado de 0 al descuento si no se proporciona
        $descuentoTotal = $request->has('descuento') ? $descuento : 0;

        // Crear la venta
        $venta = Venta::create([
            'usuario_id' => Auth::id(),
            'cantidad_total' => count($productos),
            'subtotal' => $subtotal,
            'descuentos_totales' => $descuentoTotal,
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
            'numero_factura' => $this->generateCodeFact($venta->id, Auth::id()),
            'total' => $subtotal,
            'impuesto' => $total_impuestos,
            'total_con_impuesto' => $total,
            'ventas_id' => $venta->id,
        ]);

        //Verificar si se tiene que imprimir la factura
        
        if ($request->has('imprimir')) {
            return $this->generarFacturaPDF($venta->id);
        }

        return redirect()->route('ventas.create')->with('success', 'Venta creada exitosamente.');
    }

    //Metodo para generar el codigo de la factura
    private function generateCodeFact(int $id_venta, int $id_usuario): string
    {
        $current_date = now();
        //Fomatear la fecha
        $fecha = $current_date->format('Ymd');
        return $id_venta . '' . $id_usuario . '' . $fecha;
    }
    
    //Metodo para generar el pdf
    public function generarFacturaPDF($id)
    {
        $venta = Venta::with('ventas_items.producto', 'user')->findOrFail($id);
        $factura = Factura::where('ventas_id', $id)->first();

        $data = [
            'venta' => $venta,
            'factura' => $factura,
        ];

        $pdf = Pdf::loadView('ventas.factura_pdf', $data);

        return $pdf->download('factura_' . $venta->id . '.pdf');
    }
}
