<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Kas;
use \App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KasController extends Controller
{
    public function index(Request $request)
    {
        $kategoris = Kategori::all();
        $kat = [];
        foreach ($kategoris as $item) {
            $kat[] = [
                'value' => $item->id,
                'text' => $item->nama,
                'class' => $item->class,
                'selected' => $item->selected,
            ];
        }
        return view('kas.index', compact('kat'));
    }
    public function getPucer(Request $request, $id)
    {
        $kas = Kas::find($id);
        $pdf = Pdf::loadView('export.tes', [
            'kas' => $kas,
            'ketua' => $request->get('ketua'),
            'bendahara' => $request->get('bendahara'),
        ])->setPaper('a4', 'landscape');
        return $pdf->download('voucher-' . $kas->no_kas . '.pdf');
    }
    public function storePucer(Request $request, $id = null)
    {
        if ($id != null) {
            $kas = Kas::find($request->id);
            $pdf = Pdf::loadView('export.tes', [
                'kas' => $kas,
            ])->setPaper('a4', 'landscape');
            return $pdf->download('voucher-' . $kas->no_kas . '.pdf');
        } else {
            $request->validate([
                'jumlah' => 'required',
                'tanggal' => 'required',
                'jenis' => 'required',
                'keterangan' => 'required',
                'kategori' => 'required',
            ]);
            DB::beginTransaction();
            try {
                $kas = new Kas();
                $kas->jumlah = $request->jumlah;
                $kas->tanggal = Carbon::parse($request->tanggal)->translatedFormat('d F Y');
                $kas->jenis = $request->jenis;
                $kas->keterangan = $request->keterangan;
                $kas->setSaldo();
                $kas->setNomorKas("/KK/" . Carbon::parse($request->tanggal)->format('m') . "/" . Carbon::parse($request->tanggal)->format('Y'));

                $kas->save();
                $kas->kategoris()->attach($request->kategori);
                DB::commit();
                return response()->json(['success' => 'Data berhasil ditambahkan', 'id' => $kas->id]);
                // return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            } catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }
        }
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'jumlah' => 'required',
            'tanggal' => 'required',
            'jenis' => 'required',
            'keterangan' => 'required',
            'kategori' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $kas = new Kas();
            $kas->jumlah = $request->jumlah;
            $kas->tanggal = Carbon::parse($request->tanggal)->translatedFormat('d F Y');
            $kas->jenis = $request->jenis;
            $kas->keterangan = $request->keterangan;
            $kas->setSaldo();
            if ($request->jenis == 'masuk') {
                $kas->setNomorKas("/DK/" . Carbon::parse($request->tanggal)->format('m') . "/" . Carbon::parse($request->tanggal)->format('Y'));
            } else {
                $kas->setNomorKas("/KK/" . Carbon::parse($request->tanggal)->format('m') . "/" . Carbon::parse($request->tanggal)->format('Y'));
            }
            $kas->save();
            $kas->kategoris()->attach($request->kategori);
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function riwayat(Request $request)
    {
        $start_date = $request->start ?? date('Y-m-d', 0);
        $end_date = $request->end ?? Carbon::now();
        $kategori = $request->kategori ?? [];
        $selected_kategori = $request->kategori ?? [];
        if ($kategori != []) {
            $kas = Kas::whereBetween('created_at', [$start_date, $end_date], $boolean = 'or')
                ->whereHas('kategoris', function ($query) use ($kategori) {
                    $query->whereIn('kategoris.id', $kategori);
                })->orderByDesc('created_at')->get();
        } else {
            $kas = Kas::whereBetween('created_at', [$start_date, $end_date], $boolean = 'or')->orderByDesc('created_at')->get();
        }
        // $kas = Kas::orderByDesc('created_at')->get();
        $kategoris = Kategori::all();
        $kat = [];
        foreach ($kategoris as $item) {
            $kat[] = [
                'value' => $item->id,
                'text' => $item->nama,
                'class' => $item->class,
                'selected' => $item->selected,
            ];
        }
        return view('kas.riwayat', compact('kas', 'kat', 'start_date', 'end_date', 'selected_kategori'));
    }
    public function cetak(Request $request)
    {
        $start_date = $request->start ?? date('Y-m-d', 0);
        $end_date = $request->end ?? Carbon::now();
        $ketua = $request->ketua ?? '';
        $bendahara = $request->bendahara ?? '';
        $kas = Kas::whereBetween(
            'created_at',
            [$start_date, $end_date],
            $boolean = 'or'
        )->get();
        $kasBeforeSaldo = Kas::where('created_at', '<', $start_date)->orderByDesc('created_at')->first()->saldo;
        // $saldo = $kasBeforeSaldo ? $kasBeforeSaldo->saldo : 0;
        $pdf = Pdf::loadView('export.riwayatKas', [
            'kas' => $kas,
            'start_date' => Carbon::parse($start_date)->translatedFormat('d F Y'),
            'end_date' => Carbon::parse($end_date)->translatedFormat('d F Y'),
            'ketua' => $ketua,
            'bendahara' => $bendahara,
            'saldoAwal' => $kasBeforeSaldo,
        ])->setPaper('a4', 'landscape');
        return $pdf->download('riwayat-kas.pdf');
    }
    public function tescetak()
    {
        $kas = Kas::where('jenis', 'keluar')->first();
        $pdf = Pdf::loadView('export.tes', [
            'kas' => $kas,
        ])->setPaper('a4', 'landscape');
        return $pdf->download();
        return view('export.tes', [
            'kas' => $kas,
        ]);
    }
}
