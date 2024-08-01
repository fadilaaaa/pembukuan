<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Carbon\Carbon;
use \Carbon\CarbonPeriod;


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
        \App\Models\Kategori::create([
            "nama" => "inventaris",
            "class" => "badge-success"
        ]);
        \App\Models\Kategori::create([
            "nama" => "personalia",
            "class" => "badge-warning"
        ]);

        $datearr = CarbonPeriod::create(Carbon::now()->subYear()->startOfMonth(), Carbon::now())->toArray();
        foreach ($datearr as $date) {
            $jenis = $faker->randomElement(["masuk", "keluar"]);
            // $date = $ta;

            $kategori = $faker->randomElement([1, 2]);
            $kas = \App\Models\Kas::create([
                "no_kas" => '',
                "tanggal" => $date->translatedFormat('d F Y'),
                "jenis" => $jenis,
                "jumlah" => $faker->numberBetween(100000, 1000000),
                "keterangan" => $faker->sentence(),
                "created_at" => strtotime($date)
            ]);
            if ($jenis == "keluar") {
                $kas->no_kas = $kas->id . "/KK/" . $date->format('m') . "/" . $date->format('Y');
            }
            if ($jenis == "masuk") {
                $kas->no_kas = $kas->id . "/DK/" . $date->format('m') . "/" . $date->format('Y');
            }
            $kas->save();
            $kas->kategoris()->attach($kategori);
        }
    }
}
