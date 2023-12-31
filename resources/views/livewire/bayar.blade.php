<div>
    <article class="large-elevate large-padding">

        <x-heading title="Bayar" subtitle="Daftar tagihan bulan ini & yang belum lunas" action="false" />

        <div class="grid">
            <div class="s12 m6">
                <div class="field label prefix border">
                    <i>search</i>
                    <input wire:model="cari" type="text" placeholder=" ">
                    <label>Cari</label>
                </div>
            </div>
            <div class="s6 m3">
                <div class="field label suffix border">
                    <select wire:model="status" class="active">
                        <option value="semua">Semua</option>
                        <option value="lunas">Lunas</option>
                        <option value="belum">Belum Lunas</option>
                    </select>
                    <label class="active">Status</label>
                    <i>arrow_drop_down</i>
                </div>
            </div>
        </div>

        <x-dialog id="bayar" action="{{ $action }}" title="Tagihan"
            submit="{{ $action == 'edit' ? 'Simpan' : 'Bayar' }}">
            <h5 class="small">Nama : {{ $nama }} ({{ $telepon }})</h5>
            <div class="divider"></div>
            <h5 class="small">Tagihan : {{ $bulan }}</h5>

            @if ($action == 'edit')
                <h5 class="small">Paket : {{ $paket }}</h5>
                <div class="grid">
                    <div class="s12 m6"><x-input name="tambahan1" label="Tambahan" /></div>
                    <div class="s12 m6"><x-input name="biaya1" label="Biaya (Rp)" type="number" live="true" />
                    </div>
                    <div class="s12 m6 middle-align right-align">
                        <h6 class="small">Diskon : Rp. </h6>
                    </div>
                    <div class="s12 m6"><x-input name="diskon" label="Diskon" type="number" live="true" /></div>
                </div>
            @else
                <div class="row">
                    <h5 class="small max">Paket</h5>
                    <h5 class="small">{{ $paket }}</h5>
                </div>
                @if ($biaya1 != null)
                    <div class="row">
                        <h5 class="small max">Tambahan</h5>
                        <h5 class="small">@ @rupiah($biaya1)</h5>
                    </div>
                @endif
                @if ($diskon != null)
                    <div class="row">
                        <h5 class="small max">Diskon</h5>
                        <h5 class="small">@ @rupiah($diskon)</h5>
                    </div>
                @endif
            @endif

            <h5 class="small right-align">Total Tagihan : @rupiah($totalTagihan)</h5>

            @if ($action == 'bayar')
                @if ($saldo != 0)
                    <h5 class="small right-align">- (saldo) @rupiah($saldo)</h5>
                    <h5 class="small right-align">= @rupiah($totalTagihan - $saldo)</h5>
                @endif
                <div class="divider"></div>
                <div class="grid">
                    <div class="s12 m6 middle-align right-align">
                        <h6 class="small">Bayar : Rp. </h6>
                    </div>
                    <div class="s12 m6">
                        <x-input name="bayar" label="Bayar" type="number" live="true" />
                    </div>
                    <div class="s12 m12 right-align">
                        <div class="field middle-align">
                            <nav class="right-align">
                                <label class="radio">
                                    <input type="radio" wire:model="jenis" value="tunai">
                                    <span>Tunai</span>
                                </label>
                                <label class="radio">
                                    <input type="radio" wire:model="jenis" value="transfer">
                                    <span>Transfer</span>
                                </label>
                            </nav>
                        </div>
                    </div>
                </div>
                <h5 class="small right-align">Kembali (saldo) : @if ($kembali > 0)
                        @rupiah($kembali)
                    @else
                        -
                    @endif
                </h5>
            @endif
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Telepon', 'Area', 'Alamat', 'Tgl Tagihan', 'Total Tagihan', 'Lunas', '']">
            @forelse ($tagihans as $tagihan)
                @php
                    // get year and month from tagihan->bulan
                    $a = substr($tagihan->bulan, 0, 8);
                    // get tanggal_tagihan from tagihan->pelanggan->tanggal_tagihan and add padding 0 if < 10
                    $b = str_pad($tagihan->pelanggan->tanggal_tagihan, 2, '0', STR_PAD_LEFT);
                    // combine $a and $b
                    $c = $a . $b;
                    // convert to date
                    $d = \Carbon\Carbon::parse($c);

                    $color = $tagihan->is_lunas == false && $d->isPast() ? 'yellow' : '';
                @endphp
                <tr class="{{ $color }}">
                    <td>{{ $tagihans->firstItem() + $loop->iteration - 1 }}</td>
                    <td>{{ $tagihan->pelanggan->nama }}</td>
                    <td>{{ $tagihan->pelanggan->telepon }}</td>
                    <td>{{ $tagihan->pelanggan->area->nama }}</td>
                    <td>{{ $tagihan->pelanggan->alamat }}</td>
                    <td>
                        {{ $tagihan->pelanggan->tanggal_tagihan }}
                        {{ \Carbon\Carbon::parse($tagihan->bulan)->locale('id')->monthName }}
                    </td>
                    <td>
                        @php
                            $total = (int) $tagihan->pelanggan->paket->tarif + (int) $tagihan->pelanggan->biaya1 + (int) $tagihan->pelanggan->biaya2 - (int) $tagihan->pelanggan->diskon;
                            if ($tagihan->total_tagihan != 0) {
                                $total = $tagihan->total_tagihan;
                            }
                        @endphp
                        @rupiah($total)
                    </td>
                    <td>
                        @if ($tagihan->is_lunas == true)
                            <i>done</i>
                        @else
                            @if ($d->isPast())
                                <i class="red-text">warning</i>
                            @else
                                <i>remove</i>
                            @endif
                        @endif
                    </td>
                    <td>
                        <nav class="right-align">
                            @if ($tagihan->is_lunas == false && $d->isPast())
                                <a wire:click="notif({{ $tagihan->id }})">
                                    <i>notifications</i>
                                </a>
                            @endif
                            @if ($tagihan->is_lunas == false)
                                <a wire:click="edit({{ $tagihan->id }})">
                                    <i>edit</i>
                                </a>
                                <a wire:click="bayar({{ $tagihan->id }})">
                                    <i>payments</i>
                                </a>
                            @endif
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data.</td>
                </tr>
            @endforelse
        </x-table>
        {{ $tagihans->links() }}

    </article>
</div>
