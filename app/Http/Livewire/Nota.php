<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use Vinkla\Hashids\Facades\Hashids;

class Nota extends Component
{
    public $paket, $totalTagihan, $nama, $telepon, $iuran, $tambahan1, $biaya1, $tambahan2, $biaya2, $diskon, $bulan, $tanggal;

    public function mount($id)
    {
        $decoded = Hashids::decode($id);

        if (empty($decoded)) {
            abort(404);
        }

        $transaksi = Transaksi::withTrashed()->find($decoded[0]);
        $this->paket = $transaksi->pelanggan->paket->nama;
        $this->nama = $transaksi->pelanggan->nama;
        $this->telepon = $transaksi->pelanggan->telepon;
        $this->iuran = $transaksi->pelanggan->paket->tarif;
        $this->tambahan1 = $transaksi->pelanggan->tambahan1;
        $this->biaya1 = $transaksi->pelanggan->biaya1;
        $this->tambahan2 = $transaksi->pelanggan->tambahan2;
        $this->biaya2 = $transaksi->pelanggan->biaya2;
        $this->diskon = $transaksi->pelanggan->diskon;
        $this->bulan = $transaksi->tagihan->bulan->locale('id')->isoFormat('MMMM Y');
        $this->tanggal = $transaksi->created_at->locale('id')->isoFormat('dddd, D MMMM Y');
        $this->totalTagihan = $transaksi->total_tagihan;
    }

    public function render()
    {
        return view('livewire.nota')->layout('layouts.guest', ['title' => 'Nota']);
    }
}
