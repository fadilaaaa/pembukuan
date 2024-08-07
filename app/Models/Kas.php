<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kas extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function balance()
    {
        return \App\Models\Kas::where('jenis', 'masuk')->sum('jumlah') - \App\Models\Kas::where('jenis', 'keluar')->sum('jumlah');
    }
    public static function debetToday()
    {
        return \App\Models\Kas::where('jenis', 'masuk')
            ->where('tanggal', Carbon::now()->translatedFormat('d F Y'))
            ->sum('jumlah');
    }
    public static function kreditToday()
    {
        return \App\Models\Kas::where('jenis', 'keluar')
            ->where('tanggal', Carbon::now()->translatedFormat('d F Y'))
            ->sum('jumlah');
    }
    public function setSaldo()
    {
        $beforeKas = \App\Models\Kas::orderBy('id', 'desc')->first();
        if ($this->jenis == 'masuk') {
            $this->saldo = $beforeKas ? $beforeKas->saldo + $this->jumlah : $this->jumlah;
        } else {
            $this->saldo = $beforeKas ? $beforeKas->saldo - $this->jumlah : $this->jumlah;
        }
    }
    public function setNomorKas($suff)
    {
        $beforeKasId = \App\Models\Kas::orderBy('id', 'desc')->first()->id ?? 0;
        $this->no_kas = $beforeKasId + 1 . $suff;
    }
    public function kategoris()
    {
        return $this->belongsToMany(\App\Models\Kategori::class);
    }
}
