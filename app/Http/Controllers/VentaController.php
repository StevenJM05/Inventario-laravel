<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {

    }

    public function create(){
        return view('ventas.addsale');
    }
}
