<div>
    <article class="large-elevate large-padding">

        <x-heading title="Transaksi" subtitle="Daftar transaksi" action="false" />

        <div class="grid">
            <div class="s12 m6">
                <div class="field label prefix border">
                    <i>search</i>
                    <input wire:model="cari" type="text" placeholder=" ">
                    <label>Cari</label>
                </div>
            </div>
            <div class="s12 m3">
                <div class="field label suffix border">
                    <select wire:model="filterBulan" class="active">
                        <option value="0">-</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <label class="active">Bulan</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
            <div class="s12 m3">
                <div class="field label suffix border">
                    <select wire:model="filterTahun" class="active">
                        @for ($i = 2023; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <label class="active">Tahun</label>
                    <i>arrow_drop_down</i>
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
            @if ($biaya1 != null)
                <div class="grid">
                    <div class="s6 middle-align">Biaya Tambahan</div>
                    <div class="s6 bold right-align">{{ $tambahan1 }} @ @rupiah($biaya1)</div>
                </div>
                <div class="small-divider"></div>
            @endif
            @if ($diskon != null)
                <div class="grid">
                    <div class="s6 middle-align">Diskon</div>
                    <div class="s6 bold right-align">
                        @rupiah($diskon)
                    </div>
                </div>
                <div class="small-divider"></div>
            @endif
            @if ($iuran + $biaya1 + $biaya2 - $diskon - $totalTagihan != 0)
                <div class="grid">
                    <div class="s6 middle-align">Saldo Terpakai</div>
                    <div class="s6 bold right-align">
                        - @rupiah($iuran + $biaya1 + $biaya2 - $diskon - $totalTagihan)
                    </div>
                </div>
                <div class="small-divider"></div>
            @endif
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
            <div class="space"></div>
            <nav class="no-space center-align">
                <button class="border no-round max vertical" wire:click.prevent="cetak">
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

        <x-table :headers="['#', 'Nama', 'Telepon', 'Paket', 'Area', 'Nominal', 'Metode', 'Waktu', '']">
            @forelse($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksis->firstItem() + $loop->iteration - 1 }}</td>
                    <td>{{ $transaksi->pelanggan->nama }}</td>
                    <td>{{ $transaksi->pelanggan->telepon }}</td>
                    <td>{{ $transaksi->pelanggan->paket->nama }}</td>
                    <td>{{ $transaksi->pelanggan->area->nama }}</td>
                    <td>@rupiah($transaksi->total_tagihan)</td>
                    <td>{{ $transaksi->jenis }}</td>
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
                    <td colspan="9" class="text-center">Tidak ada data</td>
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
