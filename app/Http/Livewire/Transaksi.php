<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Transaksi as TransaksiModel;
use Vinkla\Hashids\Facades\Hashids;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Transaksi extends Component
{
    use WithPagination;

    public $paket, $nama, $telepon, $iuran, $tambahan1, $biaya1, $tambahan2, $biaya2, $diskon, $bulan, $tanggal, $tanggalRaw, $totalTagihan;
    public $hashedId;
    public $action, $cari = '';
    public static $printerName = "test";
    public static $lineCharacterLength = 32;

    public function render()
    {
        return view('livewire.transaksi', [
            'transaksis' => TransaksiModel::withTrashed()->whereHas('pelanggan', function ($query) {
                $query->where('nama', 'like', '%' . $this->cari . '%')
                    ->orWhere('telepon', 'like', '%' . $this->cari . '%');
            })->orderBy('created_at', 'desc')->paginate(20),
        ])->layoutData(['title' => 'Transaksi']);
    }

    public function updatingCari()
    {
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'components.pagination';
    }

    public function nota($id)
    {
        $this->reset();
        $this->resetErrorBag();

        $transaksi = TransaksiModel::withTrashed()->find($id);
        $this->paket = $transaksi->pelanggan->paket->nama;
        $this->nama = $transaksi->pelanggan->nama;
        $this->telepon = $transaksi->pelanggan->telepon;
        $this->iuran = $transaksi->pelanggan->paket->tarif;

        $this->tambahan1 = $transaksi->tagihan->tambahan1;
        $this->biaya1 = $transaksi->tagihan->biaya1;
        $this->tambahan2 = $transaksi->tagihan->tambahan2;
        $this->biaya2 = $transaksi->tagihan->biaya2;
        $this->diskon = $transaksi->tagihan->diskon;
        $this->bulan = $transaksi->tagihan->bulan->locale('id')->isoFormat('MMMM Y');

        $this->tanggal = $transaksi->created_at->locale('id')->isoFormat('dddd, D MMMM Y');
        $this->tanggalRaw = $transaksi->created_at;
        $this->totalTagihan = $transaksi->total_tagihan;
        $this->hashedId = Hashids::encode($transaksi->id);

        $this->action = '';
        $this->dispatchBrowserEvent('showDialog', ['id' => 'nota']);
    }

    public function whatsapp()
    {
        $message = "
        RT RW NET

        NOTA ELEKTRONIK
        " . config('app.url') . "/nota/$this->hashedId

        Yth. Bapak / Ibu
        $this->nama
        $this->telepon

        *PEMBAYARAN*
        Tanggal Bayar : $this->tanggal

        Tagihan Bulan : $this->bulan
        Jenis Paket : $this->paket
        Harga Paket : Rp. " . number_format($this->iuran, 0, ',', '.') . "
        Biaya 1 : $this->tambahan1 @ Rp. " . number_format($this->biaya1, 0, ',', '.') . "
        Biaya 2 : $this->tambahan2 @ Rp. " . number_format($this->biaya2, 0, ',', '.') . "
        Diskon : Rp. " . number_format($this->diskon, 0, ',', '.') . "
        Saldo Terpakai : - Rp. " . number_format($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan, 0, ',', '.') . "
        Total Biaya : Rp. " . number_format($this->totalTagihan, 0, ',', '.') . "
        Keterangan : LUNAS

        Terima Kasih

        SUPPORT BY :
        CV. Media Computindo
        ";

        // telepon remove all non numeric characters, if first character is 0, replace with 62
        $telepon = preg_replace('/\D/', '', $this->telepon);
        if (substr($telepon, 0, 1) == '0') {
            $telepon = '62' . substr($telepon, 1);
        }

        $urlEncodedMessage = urlencode($message);

        // remove ++++++++ from urlencoded message
        $urlEncodedMessage = str_replace('++++++++', '', $urlEncodedMessage);

        // send message using wa.me
        $url = "https://wa.me/$telepon?text=$urlEncodedMessage";

        // redirect with open new tab
        $this->dispatchBrowserEvent('openNewTab', ['url' => $url]);
    }

    public function cetak()
    {
        try {
            $connector = new WindowsPrintConnector(self::$printerName);
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("RT RW NET\n");
            $printer->text("NOTA PEMBAYARAN\n");
            $printer->text(self::doubleLine());

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text(self::dualColumnText('Waktu', $this->tanggalRaw->format('d-m-Y H:i')));
            $printer->text(self::dualColumnText('Tagihan Bulan', $this->bulan));
            $printer->text(self::dualColumnText('Jenis Paket', $this->paket));
            $printer->text(self::dualColumnText('Harga Paket', 'Rp. ' . number_format($this->iuran, 0, ',', '.')));
            $printer->text(self::dualColumnText('Biaya 1', $this->tambahan1 . ' @ Rp. ' . number_format($this->biaya1, 0, ',', '.')));
            $printer->text(self::dualColumnText('Biaya 2', $this->tambahan2 . ' @ Rp. ' . number_format($this->biaya2, 0, ',', '.')));
            $printer->text(self::dualColumnText('Diskon', 'Rp. ' . number_format($this->diskon, 0, ',', '.')));
            $printer->text(self::dualColumnText('Saldo Terpakai', '- Rp. ' . number_format($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan, 0, ',', '.')));
            $printer->text(self::dualColumnText('Total Biaya', 'Rp. ' . number_format($this->totalTagihan, 0, ',', '.')));
            $printer->text(self::dualColumnText('Keterangan', 'LUNAS'));
            $printer->text(self::line());

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima Kasih\n");
            $printer->text(self::doubleLine());

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("SUPPORT BY:\n");
            $printer->text("CV. Media Computindo\n");
            $printer->feed();

            $printer->cut();
            $printer->close();

            $this->dispatchBrowserEvent('closeDialog', ['id' => 'nota']);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Berhasil mencetak nota.']);
        } catch (\Exception $e) {
            // $this->dispatchBrowserEvent('showToast', ['message' => 'Gagal mencetak nota.']);
        }
    }

    public static function dualColumnText(string $left, string $right): string
    {
        $left = substr($left, 0, 22);

        $remaining = self::$lineCharacterLength - (strlen($left) + strlen($right));

        if ($remaining <= 0) {
            $remaining = 1;
        }

        return $left . str_repeat(' ', $remaining) . $right . "\n";
    }

    public static function doubleLine(): string
    {
        return str_repeat('=', self::$lineCharacterLength) . "\n";
    }

    public static function line(): string
    {
        return str_repeat('-', self::$lineCharacterLength) . "\n";
    }
}
