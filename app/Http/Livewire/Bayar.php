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
