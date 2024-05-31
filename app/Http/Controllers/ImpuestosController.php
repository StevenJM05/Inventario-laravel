<?php

namespace App\Http\Controllers;

use App\Models\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    public function index()
    {
        $impuestos = Impuesto::paginate(10);  
        return view('impuestos.index', compact('impuestos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'porcentaje' => 'required|numeric',
        ]);

        Impuesto::create($request->all());

        return redirect()->route('impuestos.index')->with('success', 'Impuesto creado exitosamente');
    }

    public function update(Request $request, Impuesto $impuesto)
    {
        $request->validate([
            'porcentaje' => 'required|numeric',
        ]);

        $impuesto->update($request->all());

        return redirect()->route('impuestos.index')->with('success', 'Impuesto actualizado exitosamente');
    }

    public function destroy(Impuesto $impuesto)
    {
        $impuesto->delete();

        return redirect()->route('impuestos.index')->with('success', 'Impuesto eliminado exitosamente');
    }
}
