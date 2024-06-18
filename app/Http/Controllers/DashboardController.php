<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVentas = Venta::sum('total');
        $totalCompras = Compra::sum('total');
        $productosCount = Producto::count();
        $usuariosCount = User::count();

        return view('dashboard.index', compact('totalVentas', 'totalCompras', 'productosCount', 'usuariosCount'));
    }
}
