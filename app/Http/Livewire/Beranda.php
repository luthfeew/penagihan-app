<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Transaksi;

class Beranda extends Component
{
    public function render()
    {
        return view('livewire.beranda', [
            'pelanggan' => Pelanggan::count(),
            'pelangganBaru' => Pelanggan::whereMonth('created_at', date('m'))->count(),
            'lunas' => Tagihan::where('is_lunas', true)->count(),
            'belumLunas' => Tagihan::where('is_lunas', false)->count(),
            'laba' => Transaksi::sum('total_tagihan'),
            'tagihans' => Tagihan::where('is_lunas', false)->get(),
        ])->layoutData(['title' => 'Beranda']);
    }
}
