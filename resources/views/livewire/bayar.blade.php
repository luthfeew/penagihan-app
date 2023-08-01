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

        {{-- <x-dialog id="area" action="{{ $action }}" title="Area">
            <x-input name="nama" label="Nama Area" />
        </x-dialog> --}}

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
                            $totalTagihan = $tagihan->pelanggan->paket->tarif + $tagihan->pelanggan->paket->biaya1 + $tagihan->pelanggan->paket->biaya2 - $tagihan->pelanggan->paket->diskon;
                        @endphp
                        @rupiah($totalTagihan)
                    </td>
                    <td>
                        @if ($tagihan->is_lunas == true)
                            <i>check_circle</i>
                        @else
                            @if ($tagihan->pelanggan->tanggal_tagihan <= date('d'))
                                <i>warning</i>
                            @else
                                <i>circle</i>
                            @endif
                        @endif
                    </td>
                    <td>
                        <nav class="right-align">
                            @if ($tagihan->is_lunas == false)
                                <a wire:click="bayar({{ $tagihan->id }})" @click="open('bayar')">
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
