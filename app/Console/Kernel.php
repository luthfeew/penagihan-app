<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Tagihan;
use App\Models\Pelanggan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // buat daftar tagihan setiap tanggal 1
        $schedule->call(function () {
            foreach (Pelanggan::all() as $pelanggan) {
                Tagihan::create([
                    'pelanggan_id' => $pelanggan->id,
                    'bulan' => date('Y-m-d'),
                    'tambahan1' => $pelanggan->tambahan1,
                    'biaya1' => $pelanggan->biaya1 ?? 0,
                    'diskon' => $pelanggan->diskon ?? 0,
                    'is_lunas' => false,
                ]);
            }
        })->monthlyOn(1, '00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
