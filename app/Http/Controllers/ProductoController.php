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
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'marca_id' => 'required|exists:marcas,id',
            'categorias_id' => 'required|exists:categorias,id',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'is_available' => 'boolean',
            'stock' => 'required|integer',
            'impuestos_id' => 'required|exists:impuestos,id',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'marca_id' => 'required|exists:marcas,id',
            'categorias_id' => 'required|exists:categorias,id',
            'unidad_medida_id' => 'required|exists:unidad_medidas,id',
            'is_available' => 'boolean',
            'stock' => 'required|integer',
            'impuestos_id' => 'required|exists:impuestos,id',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
