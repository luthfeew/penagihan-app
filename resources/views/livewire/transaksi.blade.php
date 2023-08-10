<div>
    <article>

        <x-heading title="Transaksi" subtitle="Daftar transaksi" action="false" />

        <div class="grid">
            <div class="s12 m6">
                <div class="field label prefix border">
                    <i>search</i>
                    <input wire:model="cari" type="text" placeholder=" ">
                    <label>Cari</label>
                </div>
            </div>
        </div>

        <x-dialog id="nota" action="{{ $action }}" title="Nota Pembayaran">
            {{-- <div id="printableArea"> --}}
            <nav class="center-align">
                <i class="extra">router</i>
                <h5>NET</h5>
            </nav>
            <div class="space"></div>
            <div class="secondary-container no-round">
                <p class="no-margin">Total Pembayaran</p>
                <h5 class="small no-margin">{{ $paket }}</h5>
                <h4 class="small no-margin">@rupiah($totalTagihan)</h4>
            </div>
            <div class="space"></div>
            <p class="large-text">Rincian</p>
            <div class="grid">
                <div class="s6 middle-align">Nama Kepada</div>
                <div class="s6 bold right-align">
                    {{ $nama }}<br>
                    {{ $telepon }}
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Iuran</div>
                <div class="s6 bold right-align">@rupiah($iuran)</div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Biaya Tambahan</div>
                <div class="s6 bold right-align">
                    {{ $tambahan1 }} @ @rupiah($biaya1)<br>
                    {{ $tambahan2 }} @ @rupiah($biaya2)
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Diskon</div>
                <div class="s6 bold right-align">
                    @rupiah($diskon)
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Saldo Terpakai</div>
                <div class="s6 bold right-align">
                    - @rupiah($iuran + $biaya1 + $biaya2 - $diskon - $totalTagihan)
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Bulan</div>
                <div class="s6 bold right-align">
                    {{ $bulan }}
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6 middle-align">Tanggal Bayar</div>
                <div class="s6 bold right-align">
                    {{ $tanggal }}
                </div>
            </div>
            <div class="small-divider"></div>
            <div class="grid">
                <div class="s6">Keterangan</div>
                <div class="s6 bold right-align">L U N A S</div>
            </div>
            {{-- </div> --}}
            <div class="space"></div>
            <nav class="no-space center-align">
                <button class="border no-round max vertical" onclick="printDiv('printableArea')" type="button">
                    <i class="small">print</i>
                    <span>Cetak</span>
                </button>
                <button class="border no-round max vertical" wire:click.prevent="whatsapp">
                    <i class="small">share</i>
                    <span>Kirim WA</span>
                </button>
            </nav>
            <div class="space"></div>
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Paket', 'Area', 'Nominal', 'Waktu', '']">
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksis->firstItem() + $loop->iteration - 1 }}</td>
                    <td>{{ $transaksi->pelanggan->nama }}</td>
                    <td>{{ $transaksi->pelanggan->paket->nama }}</td>
                    <td>{{ $transaksi->pelanggan->area->nama }}</td>
                    <td>@rupiah($transaksi->total_tagihan)</td>
                    <td>{{ $transaksi->created_at }}</td>
                    <td>
                        <nav class="right-align">
                            <a wire:click="nota({{ $transaksi->id }})">
                                <i>receipt_long</i>
                            </a>
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </x-table>
        {{ $transaksis->links() }}

    </article>
</div>

@push('scripts')
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
