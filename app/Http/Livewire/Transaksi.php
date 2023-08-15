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
    public $action, $cari = '', $filterBulan = 0, $filterTahun;
    public static $printerName = "test";
    public static $lineCharacterLength = 32;

    public function mount()
    {
        $this->filterTahun = date('Y');
    }

    public function render()
    {
        if ($this->filterBulan != 0) {
            $awal = $this->filterTahun . '-' . $this->filterBulan . '-01';
            $akhir = $this->filterTahun . '-' . $this->filterBulan . '-31';
        } else {
            $awal = $this->filterTahun . '-01-01';
            $akhir = $this->filterTahun . '-12-31';
        }

        return view('livewire.transaksi', [
            'transaksis' => TransaksiModel::withTrashed()->when($this->filterBulan != 0, function ($query) use ($awal, $akhir) {
                $query->whereBetween('created_at', [$awal, $akhir]);
            })->where('total_tagihan', 'like', '%' . $this->cari . '%')
                ->orWhere('created_at', 'like', '%' . $this->cari . '%')
                // TODO: implement area & paket
                // ->orWhereHas('area', function ($query) {
                //     $query->where('nama', 'like', '%' . $this->cari . '%');
                // })
                // ->orWhereHas('paket', function ($query) {
                //     $query->where('nama', 'like', '%' . $this->cari . '%');
                // })
                ->orWhereHas('pelanggan', function ($query) {
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
        // NOTA ELEKTRONIK
        // " . config('app.url') . "/nota/$this->hashedId

        $msg = "*" . config('app.name') . "*\n\n";
        $msg .= "Yth. Bapak / Ibu\n";
        $msg .= $this->nama . "\n";
        $msg .= $this->telepon . "\n\n";
        $msg .= "*PEMBAYARAN*\n";
        $msg .= "Waktu Bayar : " . $this->tanggal . "\n\n";
        $msg .= "Tagihan Bulan : " . $this->bulan . "\n";
        $msg .= "Jenis Paket : " . $this->paket . "\n";
        if ($this->tambahan1) {
            $msg .= "Biaya " . $this->tambahan1 . " : Rp. " . number_format($this->biaya1, 0, ',', '.') . "\n";
        }
        if ($this->diskon) {
            $msg .= "Diskon : Rp. " . number_format($this->diskon, 0, ',', '.') . "\n";
        }
        if ($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan > 0) {
            $msg .= "Saldo Terpakai : - Rp. " . number_format($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan, 0, ',', '.') . "\n";
        }
        $msg .= "Total Tagihan : Rp. " . number_format($this->totalTagihan, 0, ',', '.') . "\n";
        $msg .= "Keterangan : LUNAS\n\n";
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
            if ($this->tambahan1) {
                $printer->text(self::dualColumnText('Biaya 1', $this->tambahan1 . ' @ Rp. ' . number_format($this->biaya1, 0, ',', '.')));
            }
            if ($this->diskon) {
                $printer->text(self::dualColumnText('Diskon', 'Rp. ' . number_format($this->diskon, 0, ',', '.')));
            }
            if ($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan > 0) {
                $printer->text(self::dualColumnText('Saldo Terpakai', '- Rp. ' . number_format($this->iuran + $this->biaya1 + $this->biaya2 - $this->diskon - $this->totalTagihan, 0, ',', '.')));
            }
            $printer->text(self::dualColumnText('Total Biaya', 'Rp. ' . number_format($this->totalTagihan, 0, ',', '.')));
            $printer->text(self::dualColumnText('Keterangan', 'LUNAS'));
            $printer->text(self::line());

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Terima Kasih\n");
            $printer->text(self::doubleLine());

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("SUPPORT BY:\n");
            $printer->text("CV. Media Computindo\n");
            // TODO: add CP
            $printer->feed();

            $printer->cut();
            $printer->close();

            $this->dispatchBrowserEvent('closeDialog', ['id' => 'nota']);
            $this->dispatchBrowserEvent('showToast', ['message' => 'Berhasil mencetak nota.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('showToast', ['message' => 'Gagal mencetak nota.']);
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
