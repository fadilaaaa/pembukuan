<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kas extends Model
{
    use HasFactory;
    protected $guarded = [];

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
    public function kategoris()
    {
        return $this->belongsToMany(\App\Models\Kategori::class);
    }
}
