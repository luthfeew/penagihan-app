<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nama' => 'User Demo',
            // 'email' => 'admin@admin.com',
            'username' => 'demo',
            'password' => Hash::make('12345679'),
        ]);

        $this->call([
            PaketSeeder::class,
            AreaSeeder::class,
        ]);

        \App\Models\Pelanggan::factory(10)->create();
    }
}
