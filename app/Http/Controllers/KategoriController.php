<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        return view('setting', compact('kategori'));
    }
}
