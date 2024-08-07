<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;
use \App\Models\Kas;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        Carbon::setLocale('id');
        // $carbon = \Carbon\Carbon::now();

        \App\Models\User::create([
            "name" => "Owner",
            "username" => "owner",
            "password" => bcrypt("owner"),
            "role" => "owner",
        ]);
        \App\Models\User::create([
            "name" => "Admin",
            "username" => "admin",
            "password" => bcrypt("admin"),
            "role" => "admin",
        ]);
        // \App\Models\Kategori::create([
        //     "nama" => "inventaris",
        //     "class" => "badge-success"
        // ]);
        // \App\Models\Kategori::create([
        //     "nama" => "personalia",
        //     "class" => "badge-warning"
        // ]);

        // $datearr = CarbonPeriod::create(Carbon::now()->subYear()->startOfMonth(), Carbon::now())->toArray();
        // foreach ($datearr as $key => $date) {
        //     if ($key == 0) {
        //         $kas = new Kas();
        //         $kas->tanggal = $date->translatedFormat('d F Y');
        //         $kas->jenis = "masuk";
        //         $kas->jumlah = 5_000_000;
        //         $kas->saldo = 5_000_000;
        //         $kas->keterangan = "Saldo Awal";
        //         $kas->created_at = strtotime($date);
        //         $kas->setNomorKas("/DK/" . $date->format('m') . "/" . $date->format('Y'));
        //         // $kas->setSaldoAttribute();
        //         $kas->save();
        //     }
        //     $kas = new Kas();
        //     $kas->tanggal = $date->translatedFormat('d F Y');
        //     $kas->jenis = 'masuk';

        //     $kas->jumlah = $faker->numberBetween(100000, 1000000);
        //     $kas->keterangan = $faker->sentence();
        //     $kas->created_at = strtotime($date);
        //     $kas->setSaldo();
        //     $kategori = $faker->randomElement([1, 2]);
        //     $kas->setNomorKas("/DK/" . $date->format('m') . "/" . $date->format('Y'));
        //     $kas->save();
        //     $kas->kategoris()->attach($kategori);


        //     $kas = new Kas();
        //     $kas->tanggal = $date->translatedFormat('d F Y');
        //     $kas->jenis = 'keluar';
        //     $kas->jumlah = $faker->numberBetween(100000, 1000000);
        //     $kas->keterangan = $faker->sentence();
        //     $kas->created_at = strtotime($date);
        //     $kas->setSaldo();
        //     $kategori = $faker->randomElement([1, 2]);
        //     $kas->setNomorKas("/KK/" . $date->format('m') . "/" . $date->format('Y'));
        //     $kas->save();
        //     $kas->kategoris()->attach($kategori);
        // }
    }
}
