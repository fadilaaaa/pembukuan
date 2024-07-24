<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KasController extends Controller
{
    public function index(Request $request)
    {
        return view('kas.index');
    }

    public function riwayat(Request $request)
    {
        return view('kas.riwayat');
    }
}
