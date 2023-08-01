<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat 10 paket dummy
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Paket::create([
                'nama' => "Paket $i",
                'tarif' => rand(50, 1000) . '000',
            ]);
        }
    }
}
