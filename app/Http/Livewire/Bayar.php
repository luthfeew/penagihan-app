<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Transaksi;

class Bayar extends Component
{
    public $tagihanId, $pelangganId, $bulan, $tagihan, $tambahan1, $biaya1, $tambahan2, $biaya2, $diskon, $totalTagihan, $isLunas;
    public $cari, $action;
    public $nama, $paket, $saldo, $bayar, $kembali;

    public function render()
    {
        $data = Tagihan::leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.*')
            ->where('pelanggans.nama', 'like', '%' . $this->cari . '%')
            ->paginate(20);
        $sorted = $data->getCollection()->sortBy('pelanggan.tanggal_tagihan')->values();
        $result = $data->setCollection($sorted);

        return view('livewire.bayar', [
            'tagihans' => $result,
        ])->layoutData(['title' => 'Bayar']);
    }

    public function updated()
    {
        $this->totalTagihan = $this->tagihan + (int) ($this->biaya1 ?? 0) + (int) ($this->biaya2 ?? 0) - (int) ($this->diskon ?? 0);
        $this->kembali = (int) ($this->saldo ?? 0) + (int) ($this->bayar ?? 0) - $this->totalTagihan;
    }

    public function bayar($id)
    {
        $this->reset();
        $this->resetErrorBag();

        $tagihan = Tagihan::find($id);
        $pelanggan = Tagihan::find($id)->pelanggan;
        $this->pelangganId = $pelanggan->id;
        $this->nama = $pelanggan->nama;
        $this->saldo = $pelanggan->saldo->saldo;
        $this->paket = $pelanggan->paket->nama . ' @ Rp. ' . number_format($pelanggan->paket->tarif, 0, ',', '.');
        $this->tagihanId = $id;
        $this->bulan = $tagihan->bulan;
        $this->tagihan = $pelanggan->paket->tarif;
        $this->tambahan1 = $pelanggan->tambahan1;
        $this->biaya1 = $pelanggan->biaya1;
        $this->tambahan2 = $pelanggan->tambahan2;
        $this->biaya2 = $pelanggan->biaya2;
        $this->diskon = $pelanggan->diskon;
        $this->totalTagihan = (int) $this->tagihan + (int) $this->biaya1 + (int) $this->biaya2 - (int) $this->diskon;

        $this->action = 'bayar';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'bayar']);
    }

    public function simpan()
    {
        $this->validate([
            'bayar' => 'required|numeric|min:' . $this->totalTagihan - $this->saldo,
        ], [
            'bayar.min' => 'Pembayaran kurang',
        ]);

        $tagihan = Tagihan::find($this->tagihanId);
        $tagihan->is_lunas = true;
        $tagihan->save();

        $pelanggan = Tagihan::find($this->tagihanId)->pelanggan;
        $pelanggan->saldo->saldo = $this->kembali;
        $pelanggan->saldo->save();

        Transaksi::create([
            'tagihan_id' => $this->tagihanId,
            'pelanggan_id' => $this->pelangganId,
            'saldo_id' => $pelanggan->saldo->id,
            'kode' => 'BYR',
            'total_tagihan' => $this->totalTagihan - $this->saldo,
            'bayar' => $this->bayar,
            'lebih' => $this->kembali,
        ]);

        $this->reset();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeDialog', ['id' => 'bayar']);
        $this->dispatchBrowserEvent('showToast', ['message' => 'Tagihan berhasil dibayar']);
    }
}
