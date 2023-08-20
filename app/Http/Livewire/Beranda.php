<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Perawatan;

class Beranda extends Component
{
    public $rentang;
    public $bulan, $tahun;
    // public $awal, $akhir;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        if ($this->rentang == 'custom') {
            $awal = $this->tahun . '-' . $this->bulan . '-01 00:00:00';
            $akhir = $this->tahun . '-' . $this->bulan . '-31 23:59:59';
        } else {
            $awal = null;
            $akhir = null;
        }

        return view('livewire.beranda', [
            'pelanggan' => Pelanggan::count(),
            'pelangganBaru' => Pelanggan::when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('tanggal_register', [$awal, $akhir]);
            }, function ($query) {
                return $query->where('tanggal_register', '>=', date('Y-m-d 00:00:00', strtotime('-30 day')));
            })->count(),
            'lunas' => Tagihan::where('is_lunas', true)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('created_at', [$awal, $akhir]);
            })->count(),
            'belumLunas' => Tagihan::where('is_lunas', false)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('created_at', [$awal, $akhir]);
            })->count(),
            'laba' => Transaksi::when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('created_at', [$awal, $akhir]);
            })->sum('total_tagihan'),
            'tagihans' => Tagihan::where('is_lunas', false)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('created_at', [$awal, $akhir]);
            })->get(),
            // laba bersih = laba - perawatan
            'labaBersih' => Transaksi::when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('created_at', [$awal, $akhir]);
            })->sum('total_tagihan') - Perawatan::when($awal && $akhir, function ($query) use ($awal, $akhir) {
                return $query->whereBetween('waktu', [$awal, $akhir]);
            })->sum('biaya'),
        ])->layoutData(['title' => 'Beranda']);
    }
}
