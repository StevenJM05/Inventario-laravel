<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function index(Request $request)
    {
        $query = Kardex::with('producto');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('producto', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%");
            });
        }

        $kardexEntries = $query->paginate(10);

        return view('kardex.index', compact('kardexEntries'));
    }
}
