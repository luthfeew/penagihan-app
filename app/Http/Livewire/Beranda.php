<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Tagihan;

class Beranda extends Component
{
    public function render()
    {
        return view('livewire.beranda',[
            'pelanggans' => Pelanggan::count(),
            'newPelanggans' => Pelanggan::whereMonth('created_at', date('m'))->count(),
            'lunas' => Tagihan::where('is_lunas', true)->count(),
            'belumLunas' => Tagihan::where('is_lunas', false)->count(),
        ])->layoutData(['title' => 'Beranda']);
    }
}
