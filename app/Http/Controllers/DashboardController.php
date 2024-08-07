<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $kasMasukHariIni = \App\Models\Kas::debetToday();
        $kasKeluarHariIni = \App\Models\Kas::kreditToday();
        $dataKasMasukSeminggu = \App\Models\Kas::where('jenis', 'masuk')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->groupBy(
                function ($kas) {
                    $daftar_hari = array(
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    );
                    return $daftar_hari[$kas->created_at->format('l')];
                }
            )->map(function ($group) {
                return $group->sum('jumlah');
            });
        $dataKasKeluarSeminggu = \App\Models\Kas::where('jenis', 'keluar')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->groupBy(
                function ($kas) {
                    $daftar_hari = array(
                        'Sunday' => 'Minggu',
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa',
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu'
                    );
                    return $daftar_hari[$kas->created_at->format('l')];
                }
            )->map(function ($group) {
                return $group->sum('jumlah');
            });
        $haris = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
        ];
        $grafikKasMasuk = [];
        foreach ($haris as $hari) {
            if (!isset($dataKasMasukSeminggu[$hari])) {
                $grafikKasMasuk[$hari] = 0;
            } else {
                $grafikKasMasuk[$hari] = $dataKasMasukSeminggu[$hari];
            }
        }
        $grafikKasKeluar = [];
        foreach ($haris as $hari) {
            if (!isset($dataKasKeluarSeminggu[$hari])) {
                $grafikKasKeluar[$hari] = 0;
            } else {
                $grafikKasKeluar[$hari] = $dataKasKeluarSeminggu[$hari];
            }
        }
        $balance = \App\Models\Kas::balance();

        // dd($grafikKasMasuk, $grafikKasKeluar);
        return view('dashboard', compact('kasMasukHariIni', 'kasKeluarHariIni', 'grafikKasMasuk', 'grafikKasKeluar', 'balance'));
    }
    public function editakun(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $user = \App\Models\User::where('id', auth()->user()->id)->first();
        $user->username = $username;
        $user->password = bcrypt($password);
        $user->save();

        return redirect()->back()->with('success', 'Akun telah diupdate');
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
