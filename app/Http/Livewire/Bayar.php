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
    public $cari = '', $action;
    public $nama, $telepon, $paket, $saldo, $bayar, $kembali;
    public $jenis = 'tunai';

    public function render()
    {
        $raw = Tagihan::whereHas('pelanggan', function ($query) {
            $query->where('nama', 'like', '%' . $this->cari . '%');
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
        $this->tagihanId = $id;
        $this->bulan = $tagihan->bulan->locale('id')->isoFormat('MMMM Y');
        $this->tagihan = $pelanggan->paket->tarif;
        $this->tambahan1 = $pelanggan->tambahan1;
        $this->biaya1 = $pelanggan->biaya1;
        $this->tambahan2 = $pelanggan->tambahan2;
        $this->biaya2 = $pelanggan->biaya2;
        $this->diskon = $pelanggan->diskon;
        $this->totalTagihan = (int) $this->tagihan + (int) $this->biaya1 + (int) $this->biaya2 - (int) $this->diskon;
    }

    public function bayar($id)
    {
        $this->getData($id);
        $this->action = 'bayar';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'bayar']);
    }

    public function simpan()
    {
        $this->validate([
            'bayar' => 'required|numeric|min:' . $this->totalTagihan - $this->saldo,
            'biaya1' => 'nullable|numeric',
            'biaya2' => 'nullable|numeric',
            'diskon' => 'nullable|numeric',
            'tambahan1' => 'required_with:biaya1',
            'tambahan2' => 'required_with:biaya2',
        ], [
            'bayar.required' => 'Pembayaran tidak boleh kosong!',
            'bayar.numeric' => 'Pembayaran harus berupa angka!',
            'bayar.min' => 'Pembayaran tidak boleh kurang dari ' . number_format($this->totalTagihan - $this->saldo, 0, ',', '.'),
            'biaya1.numeric' => 'Biaya tambahan harus berupa angka!',
            'biaya2.numeric' => 'Biaya tambahan harus berupa angka!',
            'diskon.numeric' => 'Diskon harus berupa angka!',
            'tambahan1.required_with' => 'Tambahan 1 tidak boleh kosong!',
            'tambahan2.required_with' => 'Tambahan 2 tidak boleh kosong!',
        ]);

        $tagihan = Tagihan::find($this->tagihanId);
        $tagihan->tambahan1 = $this->tambahan1;
        $tagihan->biaya1 = $this->biaya1 ?? 0;
        $tagihan->tambahan2 = $this->tambahan2;
        $tagihan->biaya2 = $this->biaya2 ?? 0;
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

        $this->reset();
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('closeDialog', ['id' => 'bayar']);
        $this->dispatchBrowserEvent('showToast', ['message' => 'Tagihan berhasil dibayar']);
    }

    public function notif($id)
    {
        $this->getData($id);

        $message = "
        *RT_RW_NET*

        Yth. Bapak / Ibu
        $this->nama
        $this->telepon

        *PEMBERITAHUAN*
        Pelanggan yang terhormat, kami sampaikan detail tagihan internet anda saat ini
        Tagihan Bulan : $this->bulan
        Jenis Paket : $this->paket
        " . ($this->tambahan1 ? "Biaya $this->tambahan1 : Rp. " . number_format($this->biaya1, 0, ',', '.') . "" : "") . "
        " . ($this->tambahan2 ? "Biaya $this->tambahan2 : Rp. " . number_format($this->biaya2, 0, ',', '.') . "" : "") . "
        Diskon : Rp. " . number_format($this->diskon, 0, ',', '.') . "
        Sisa Saldo : Rp. " . number_format($this->saldo, 0, ',', '.') . "
        Total Tagihan - Sisa Saldo : Rp. " . number_format($this->totalTagihan - $this->saldo, 0, ',', '.') . "
        Ket : BELUM TERBAYAR

        TERIMA KASIH

        SUPPORT BY :
        PT.RT_RW_NET
        ";

        // telepon remove all non numeric characters, if first character is 0, replace with 62
        $telepon = preg_replace('/\D/', '', $this->telepon);
        if (substr($telepon, 0, 1) == '0') {
            $telepon = '62' . substr($telepon, 1);
        }

        // encode message
        $message = urlencode($message);

        // remove ++++++++ from urlencoded message
        $urlEncodedMessage = str_replace('++++++++', '', $message);

        // send message
        $url = "https://wa.me/$telepon?text=$urlEncodedMessage";

        // redirect with open new tab
        $this->dispatchBrowserEvent('openNewTab', ['url' => $url]);
    }
}
