<?php

namespace App\Http\Controllers;

use App\Models\Lembaga;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        $lembagas = Lembaga::where('status', true)
            ->orderBy('nama_lembaga', 'asc')
            ->get();

        return view('lembaga.index', compact('lembagas'));
    }

    public function show($id)
    {
        $lembaga = Lembaga::with('members')->where('status', true)->findOrFail($id);
        
        return view('lembaga.show', compact('lembaga'));
    }
}
