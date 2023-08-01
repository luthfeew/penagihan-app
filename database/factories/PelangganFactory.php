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
        // buat tanggal random antara hari ini sampai 28 hari ke belakang
        $tanggal = $this->faker->dateTimeBetween('-28 days', 'now')->format('Y-m-d');

        return [
            'nama' => $this->faker->name,
            'telepon' => $this->faker->phoneNumber,
            'tanggal_register' => $tanggal,
            'tanggal_tagihan' => rand(1, 31),
            'paket_id' => rand(1, 10),
            'area_id' => rand(1, 10),
            'tambahan1' => $this->faker->word,
            'biaya1' => rand(1, 100) . '000',
            'tambahan2' => $this->faker->word,
            'biaya2' => rand(1, 100) . '000',
            'diskon' => rand(1, 100) . '000',
            'alamat' => $this->faker->address,
        ];
    }
}
