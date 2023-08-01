<div>
    <article>

        <x-heading title="Bayar" subtitle="Daftar tagihan bulan ini & yang belum lunas" />

        <div class="grid">
            <div class="s12 m6">
                <div class="field label prefix border">
                    <i>search</i>
                    <input wire:model="cari" type="text" placeholder=" ">
                    <label>Cari</label>
                </div>
            </div>
        </div>

        <x-dialog id="bayar" action="{{ $action }}" title="Tagihan">
            <h5 class="small">Nama : {{ $nama }}</h5>
            <div class="divider"></div>
            <h5 class="small">Paket : {{ $paket }}</h5>
            <div class="grid">
                <div class="s12 m6 middle-align right-align">
                    <h6 class="small">Biaya Tambahan 1 : Rp. </h6>
                </div>
                <div class="s12 m6"><x-input name="biaya1" label="Tambahan 1" type="number" live="true" /></div>
                <div class="s12 m6 middle-align right-align">
                    <h6 class="small">Biaya Tambahan 2 : Rp. </h6>
                </div>
                <div class="s12 m6"><x-input name="biaya2" label="Tambahan 2" type="number" live="true" /></div>
                <div class="s12 m6 middle-align right-align">
                    <h6 class="small">Diskon : Rp. </h6>
                </div>
                <div class="s12 m6"><x-input name="diskon" label="Diskon" type="number" live="true" /></div>
            </div>
            <h5 class="small">Total Tagihan : @rupiah($totalTagihan)</h5>
            @if ($saldo != 0)
            <h5 class="small">- (saldo) @rupiah($saldo)</h5>
            <h5 class="small">= @rupiah($totalTagihan - $saldo)</h5>
            @endif
            <div class="divider"></div>
            <div class="grid">
                <div class="s12 m6">
                    <x-input name="bayar" label="Bayar" type="number" live="true" />
                </div>
                {{-- <div class="s12 m6">
                    <x-input name="kembali" label="Kembali" type="number" live="true" />
                </div> --}}
            </div>
            <h5 class="small">Kembali (saldo) : @if($kembali > 0) @rupiah($kembali) @else - @endif</h5>
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Telepon', 'Area', 'Tgl Tagihan', 'Total Tagihan', 'Lunas', '']">
            @forelse ($tagihans as $tagihan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tagihan->pelanggan->nama }}</td>
                    <td>{{ $tagihan->pelanggan->telepon }}</td>
                    <td>{{ $tagihan->pelanggan->area->nama }}</td>
                    <td>{{ $tagihan->pelanggan->tanggal_tagihan }}</td>
                    <td>
                        @php
                            $total = $tagihan->pelanggan->paket->tarif + $tagihan->pelanggan->biaya1 + $tagihan->pelanggan->biaya2 - $tagihan->pelanggan->diskon;
                        @endphp
                        @rupiah($total)
                    </td>
                    <td>
                        @if ($tagihan->is_lunas == true)
                            <i>done</i>
                        @else
                            @if ($tagihan->pelanggan->tanggal_tagihan <= date('d'))
                                <i>warning</i>
                            @else
                                <i>remove</i>
                            @endif
                        @endif
                    </td>
                    <td>
                        <nav class="right-align">
                            @if ($tagihan->is_lunas == false)
                                <a wire:click="bayar({{ $tagihan->id }})">
                                    <i>payments</i>
                                </a>
                            @endif
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Tidak ada data.</td>
                </tr>
            @endforelse
        </x-table>

    </article>
</div>
