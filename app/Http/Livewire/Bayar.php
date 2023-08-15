<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Transaksi;

class Bayar extends Component
{
    use WithPagination;

    public $tagihanId, $pelangganId, $bulan, $tagihan, $tambahan1, $biaya1, $tambahan2, $biaya2, $diskon, $totalTagihan, $isLunas;
    public $cari = '', $status = 'semua', $action;
    public $nama, $telepon, $paket, $saldo, $bayar, $kembali;
    public $jenis = 'tunai';

    public function render()
    {
        $raw = Tagihan::whereHas('pelanggan', function ($query) {
            $query->where('nama', 'like', '%' . $this->cari . '%')
                ->orWhere('telepon', 'like', '%' . $this->cari . '%')
                ->orWhere('alamat', 'like', '%' . $this->cari . '%')
                ->orWhereHas('area', function ($query) {
                    $query->where('nama', 'like', '%' . $this->cari . '%');
                })
                ->orWhere('tanggal_tagihan', 'like', '%' . $this->cari . '%');
        })->when($this->status == 'lunas', function ($query) {
            return $query->where('is_lunas', true);
        })->when($this->status == 'belum', function ($query) {
            return $query->where('is_lunas', false);
        })->paginate(20);
        $sorted = $raw->getCollection()->sortBy(function ($tagihan) {
            return [
                $tagihan->is_lunas,
                $tagihan->bulan,
                $tagihan->pelanggan->tanggal_tagihan,
            ];
        })->values();
        $tagihans = $raw->setCollection($sorted);

        return view('livewire.bayar', [
            'tagihans' => $tagihans,
        ])->layoutData(['title' => 'Bayar']);
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'components.pagination';
    }

    public function updated()
    {
        $this->totalTagihan = $this->tagihan + (int) ($this->biaya1 ?? 0) + (int) ($this->biaya2 ?? 0) - (int) ($this->diskon ?? 0);
        $this->kembali = (int) ($this->saldo ?? 0) + (int) ($this->bayar ?? 0) - $this->totalTagihan;
    }

    public function getData($id)
    {
        $this->reset();
        $this->resetErrorBag();

        $tagihan = Tagihan::find($id);
        $pelanggan = Tagihan::find($id)->pelanggan;

        $this->pelangganId = $pelanggan->id;
        $this->telepon = $pelanggan->telepon;
        $this->nama = $pelanggan->nama;
        $this->saldo = $pelanggan->saldo->saldo;
        $this->paket = $pelanggan->paket->nama . ' @ Rp. ' . number_format($pelanggan->paket->tarif, 0, ',', '.');
        $this->tagihan = $pelanggan->paket->tarif;

        $this->tagihanId = $id;
        $this->bulan = $tagihan->bulan->locale('id')->isoFormat('MMMM Y');
        $this->tambahan1 = $tagihan->tambahan1;
        $this->biaya1 = $tagihan->biaya1;
        // $this->tambahan2 = $tagihan->tambahan2;
        // $this->biaya2 = $tagihan->biaya2;
        $this->diskon = $tagihan->diskon;
        $this->totalTagihan = $this->tagihan + $this->biaya1 + $this->biaya2 - $this->diskon;
    }

    public function bayar($id)
    {
        $this->getData($id);
        $this->action = 'bayar';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'bayar']);
    }

    public function edit($id)
    {
        $this->getData($id);
        $this->action = 'edit';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'bayar']);
    }

    public function simpan()
    {
        if ($this->action == 'edit') {

            $this->validate([
                'tambahan1' => 'required_with:biaya1',
                'biaya1' => 'nullable|numeric|min:1',
                'diskon' => 'nullable|numeric|min:1',
            ], [
                'tambahan1.required_with' => 'Harus diisi jika ada biaya tambahan!',
                'biaya1.numeric' => 'Harus berupa angka!',
                'biaya1.min' => 'Tidak boleh kurang dari 1!',
                'diskon.numeric' => 'Harus berupa angka!',
                'diskon.min' => 'Tidak boleh kurang dari 1!',
            ]);

            $tagihan = Tagihan::find($this->tagihanId);
            $tagihan->tagihan = $this->tagihan;
            $tagihan->tambahan1 = $this->tambahan1 ?? null;
            $tagihan->biaya1 = $this->biaya1 ?? null;
            $tagihan->diskon = $this->diskon ?? null;
            $tagihan->total_tagihan = $this->totalTagihan;
            $tagihan->save();

            $this->dispatchBrowserEvent('showToast', ['message' => 'Tagihan berhasil diubah']);
        } else {

            $this->validate([
                'bayar' => 'required|numeric|min:' . $this->totalTagihan - $this->saldo,
            ], [
                'bayar.required' => 'Bayar tidak boleh kosong!',
                'bayar.numeric' => 'Bayar harus berupa angka!',
                'bayar.min' => 'Bayar tidak boleh kurang dari ' . number_format($this->totalTagihan - $this->saldo, 0, ',', '.'),
            ]);

            $tagihan = Tagihan::find($this->tagihanId);
            $tagihan->tambahan1 = $this->tambahan1;
            $tagihan->biaya1 = $this->biaya1 ?? 0;
            // $tagihan->tambahan2 = $this->tambahan2;
            // $tagihan->biaya2 = $this->biaya2 ?? 0;
            $tagihan->diskon = $this->diskon ?? 0;
            $tagihan->total_tagihan = $this->totalTagihan;
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
                'jenis' => $this->jenis,
            ]);

            $this->dispatchBrowserEvent('showToast', ['message' => 'Tagihan berhasil dibayar']);
        }

        // $this->reset();
        // $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeDialog', ['id' => 'bayar']);
    }

    public function notif($id)
    {
        $this->getData($id);

        $msg = "*" . config('app.name') . "*\n\n";
        $msg .= "Yth. Bapak / Ibu\n";
        $msg .= $this->nama . "\n";
        $msg .= $this->telepon . "\n\n";
        $msg .= "*PEMBERITAHUAN*\n";
        $msg .= "Pelanggan yang terhormat, kami sampaikan detail tagihan internet anda saat ini\n";
        $msg .= "Tagihan Bulan : " . $this->bulan . "\n";
        $msg .= "Jenis Paket : " . $this->paket . "\n";
        if ($this->tambahan1) {
            $msg .= "Biaya " . $this->tambahan1 . " : Rp. " . number_format($this->biaya1, 0, ',', '.') . "\n";
        }
        if ($this->diskon) {
            $msg .= "Diskon : Rp. " . number_format($this->diskon, 0, ',', '.') . "\n";
        }
        if ($this->saldo) {
            $msg .= "Sisa Saldo : Rp. " . number_format($this->saldo, 0, ',', '.') . "\n";
        }
        if ($this->totalTagihan - $this->saldo > 0) {
            $msg .= "Total Tagihan : Rp. " . number_format($this->totalTagihan - $this->saldo, 0, ',', '.') . "\n";
        }
        $msg .= "Ket : BELUM TERBAYAR\n\n";
        $msg .= "TERIMA KASIH\n\n";
        $msg .= "SUPPORT BY :\n";
        $msg .= "CV. Media Computindo";

        // telepon hanya angka, hilangkan karakter selain angka, jika diawali 0 maka ganti dengan 62
        $telepon = preg_replace('/[^0-9]/', '', $this->telepon);
        $telepon = preg_replace('/^0/', '62', $telepon);

        // encode message
        $urlEncodedMessage = urlencode($msg);

        // kirim pesan
        $url = "https://wa.me/$telepon?text=$urlEncodedMessage";

        // redirect dengan buka tab baru
        $this->dispatchBrowserEvent('openNewTab', ['url' => $url]);
    }
}
