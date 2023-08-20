<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // buat tanggal random antara hari ini sampai 90 hari ke belakang
        $tanggal = $this->faker->dateTimeBetween('-90 days', 'now')->format('Y-m-d');

        return [
            'nama' => $this->faker->name,
            'telepon' => $this->faker->phoneNumber,
            'tanggal_register' => $tanggal,
            'tanggal_tagihan' => rand(1, 31),
            'paket_id' => rand(1, 3),
            'area_id' => rand(1, 2),
            'tambahan1' => 'perawatan',
            'biaya1' => rand(5, 10) . '000',
            // 'tambahan2' => $this->faker->word,
            // 'biaya2' => rand(1, 100) . '000',
            'diskon' => rand(1, 100) . '000',
            'alamat' => $this->faker->streetAddress,
            'created_at' => $tanggal,
        ];
    }
}
