<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Transaksi;

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
        // switch ($this->rentang) {
        //         // case 1 = hari ini
        //     case 1:
        //         $awal = date('Y-m-d 00:00:00');
        //         $akhir = date('Y-m-d 23:59:59');
        //         break;
        //         // case 2 = kemarin
        //     case 2:
        //         $awal = date('Y-m-d 00:00:00', strtotime('-1 day'));
        //         $akhir = date('Y-m-d 23:59:59', strtotime('-1 day'));
        //         break;
        //         // case 3 = 7 hari terakhir
        //     case 3:
        //         $awal = date('Y-m-d 00:00:00', strtotime('-7 day'));
        //         $akhir = date('Y-m-d 23:59:59');
        //         break;
        //         // case 4 = 30 hari terakhir
        //     case 4:
        //         $awal = date('Y-m-d 00:00:00', strtotime('-30 day'));
        //         $akhir = date('Y-m-d 23:59:59');
        //         break;
        //         // case 5 = semua
        //     default:
        //         $awal = null;
        //         $akhir = null;
        //         break;
        // }


        // return view('livewire.beranda', [
        //     'pelanggan' => Pelanggan::count(),
        //     'pelangganBaru' => Pelanggan::where('tanggal_register', '>=', date('Y-m-d 00:00:00', strtotime('-30 day')))
        //         ->when($awal && $akhir, function ($query) use ($awal, $akhir) {
        //             return $query->whereBetween('tanggal_register', [$awal, $akhir]);
        //         })->count(),
        //     'lunas' => Tagihan::where('is_lunas', true)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
        //         return $query->whereBetween('created_at', [$awal, $akhir]);
        //     })->count(),
        //     'belumLunas' => Tagihan::where('is_lunas', false)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
        //         return $query->whereBetween('created_at', [$awal, $akhir]);
        //     })->count(),
        //     'laba' => Transaksi::when($awal && $akhir, function ($query) use ($awal, $akhir) {
        //         return $query->whereBetween('created_at', [$awal, $akhir]);
        //     })->sum('total_tagihan'),
        //     'tagihans' => Tagihan::where('is_lunas', false)->when($awal && $akhir, function ($query) use ($awal, $akhir) {
        //         return $query->whereBetween('created_at', [$awal, $akhir]);
        //     })->get(),
        //     // 'chart' => Tagihan::selectRaw("MONTH(bulan) as bbb,sum(total_tagihan) as tag")->whereRaw("is_lunas = true AND bulan LIKE '2023%'")->groupBy('bbb')->orderBy('bbb','asc')->get(),
        // ])->layoutData(['title' => 'Beranda']);

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
        ])->layoutData(['title' => 'Beranda']);
    }
}
