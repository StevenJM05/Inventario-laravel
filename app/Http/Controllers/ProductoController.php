<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Impuesto;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::paginate(10);
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $unidadesMedida = UnidadMedida::all();
        $impuestos = Impuesto::all();


        return view('productos.index', compact('productos', 'marcas', 'categorias', 'unidadesMedida', 'impuestos'));
    }


    public function store(Request $request)
    {
        $producto = Producto::create($request->all());
        $producto->impuestos()->sync(explode(',', $request->impuestos_id));
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->all());
        $producto->impuestos()->sync(explode(',', $request->impuestos_id));
        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
