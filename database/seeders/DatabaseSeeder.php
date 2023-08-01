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
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Luthfi Wijaya',
            'email' => 'luthfeew@gmail.com',
        ]);

        $this->call([
            PaketSeeder::class,
            AreaSeeder::class,
        ]);

        \App\Models\Pelanggan::factory(10)->create();
    }
}
