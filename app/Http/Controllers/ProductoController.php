<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\UnidadMedida;
use App\Models\Impuesto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['marca', 'categorias', 'unidad_medida', 'impuestos'])->get();
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $impuestos = Impuesto::all();
        $unidad_medida = UnidadMedida::all();
        return view('productos.index', compact('productos', 'marcas', 'categorias', 'unidad_medida', 'impuestos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'marca_id' => 'required|exists:marca,id',
            'categorias_id' => 'required|exists:categorias,id',
            'Unidad_medida_id' => 'required|exists:unidad_medida,id',
            'is_available' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'impuesto_id' => 'required|exists:impuestos,id',
        ]);
        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $unidadesMedida = UnidadMedida::all();
        $impuestos = Impuesto::all();

        return view('productos.edit', compact('producto', 'marcas', 'categorias', 'unidadesMedida', 'impuestos'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'marca_id' => 'required|exists:marca,id',
            'categorias_id' => 'required|exists:categorias,id',
            'unidad_medida_id' => 'required|exists:unidad_medida,id',
            'impuesto_id' => 'required|exists:impuestos,id',
            'is_available' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            
        ]);

        try {
            $producto = Producto::findOrFail($id);
            $producto->update($request->all());

            return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception ) {
            return redirect()->back()->with('error', 'Hubo un error al intentar actualizar el producto.');
        }
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();


        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
