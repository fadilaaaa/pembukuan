<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kasMasukHariIni = \App\Models\Kas::debetToday();
        $kasKeluarHariIni = \App\Models\Kas::kreditToday();
        // dd($kasKeluarHariIni, $kasMasukHariIni);
        return view('dashboard', compact('kasMasukHariIni', 'kasKeluarHariIni'));
    }
    public function setting(Request $request)
    {
        $kategori = \App\Models\Kategori::all();
        return view('setting', compact('kategori'));
    }
    public function setting_edit_kategori(Request $request, $id)
    {
        $kategori = \App\Models\Kategori::find($id);
        $kategori->nama = $request->nama;
        $kategori->save();
        return redirect()->back()->with('success', 'Kategori telah diupdate');
    }
    public function setting_delete_kategori(Request $request, $id)
    {
        $kategori = \App\Models\Kategori::find($id);
        $kategori->kas_tagged()->detach();
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori telah dihapus');
    }
    public function setting_add_kategori(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama' => 'required'
            ]);
            $badges = [
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info'
            ];
            \App\Models\Kategori::create([
                "nama" => $request->nama,
                'class' => 'badge-' . $badges[array_rand($badges)]
            ]);
            return redirect()->back()->with('success', 'Kategori telah ditambah');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
