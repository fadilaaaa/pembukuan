<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
    }
}
