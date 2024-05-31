<?php

namespace App\Http\Controllers;

use App\Models\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    public function index()
    {
        $impuestos = Impuesto::paginate(5);

        return view('impuestos.index', compact('impuestos'));
    }
}
