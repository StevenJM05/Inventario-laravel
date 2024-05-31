<?php

namespace App\Http\Controllers;

use App\Models\UnidadMedida;
use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    public function index()
    {
        $unidadesMedida = UnidadMedida::paginate(10);  
        return view('unidadesMedida.index', compact('unidadesMedida'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prefijo' => 'required|string|max:10',
        ]);

        UnidadMedida::create($request->all());

        return redirect()->route('unidadesMedida.index')->with('success', 'Unidad de Medida creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'prefijo' => 'required|string|max:10',
        ]);

        $unidadMedida= UnidadMedida::findOrFail($id);
        $unidadMedida->update($request->all());

        return redirect()->route('unidadesMedida.index')->with('success', 'Unidad de Medida actualizada exitosamente');
    }

    public function destroy(UnidadMedida $unidadMedida)
    {
        $unidadMedida->delete();

        return redirect()->route('unidadesMedida.index')->with('success', 'Unidad de Medida eliminada exitosamente');
    }
}
