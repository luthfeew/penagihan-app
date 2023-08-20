<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat 2 area dummy
        for ($i = 1; $i <= 2; $i++) {
            \App\Models\Area::create([
                'nama' => "Area $i",
            ]);
        }
    }
}
