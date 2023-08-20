<div>
    <article class="large-elevate large-padding">

        <x-heading title="Pelanggan" subtitle="Daftar pelanggan" />

        <div class="grid">
            <div class="s12 m6">
                <div class="field label prefix border">
                    <i>search</i>
                    <input wire:model="cari" type="text" placeholder=" ">
                    <label>Cari</label>
                </div>
            </div>
        </div>

        <x-dialog size="large" id="pelanggan" action="{{ $action }}" title="Pelanggan">
            @if ($action == 'lihat')
                <h5 class="small">Saldo : @rupiah($saldo)</h5>
            @endif
            <div class="row">
                <h5 class="small">Data Identitas</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="grid">
                <div class="s12 m6">
                    <x-input name="nama" label="Nama" />
                </div>
                <div class="s12 m6">
                    <x-input name="telepon" label="Nomor Telepon / WA" />
                </div>
                <div class="s12 m4">
                    <x-input name="tglRegister" label="Tanggal Register" type="date" icon="today"
                        helper="{{ $tglRegister ? '' : '(opsional, jika kosong otomatis hari ini)' }}" />
                </div>
                <div class="s12 m4">
                    <x-input name="tglTagihan" label="Tanggal Tagihan" type="number" helper="{{ $tglTagihan ? '' : '(opsional, jika kosong otomatis hari ini)' }}" />
                </div>
                {{-- <div class="s12 m4">
                    <x-input name="tglIsolir" label="Tanggal Isolir" type="number" helper="(opsional)" />
                </div> --}}
                <div class="s12 m6">
                    <x-select name="paket" label="Paket" :options="$listPaket"
                        empty="Paket belum ada, silakan tambah melalui pengaturan." />
                </div>
                <div class="s12 m6">
                    <x-select name="area" label="Area" :options="$listArea"
                        empty="Area belum ada, silakan tambah melalui pengaturan." />
                </div>
            </div>
            <div class="row">
                <h5 class="small">Biaya Lain (opsional)</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="space"></div>
            <div class="grid">
                <div class="s12 m6">
                    <x-input name="tambahan1" label="Tambahan" />
                </div>
                <div class="s12 m6">
                    <x-input name="biaya1" label="Biaya (Rp)" type="number" />
                </div>
                {{-- <div class="s12 m6">
                    <x-input name="tambahan2" label="Tambahan 2" />
                </div>
                <div class="s12 m6">
                    <x-input name="biaya2" label="Biaya 2" type="number" />
                </div> --}}
                <div class="s12 m6">
                    <x-input name="diskon" label="Diskon (Rp)" type="number" />
                </div>
            </div>
            <div class="row">
                <h5 class="small">Data Modem (opsional)</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="space"></div>
            <div class="grid">
                <div class="s12 m6">
                    <x-input name="ppoe" label="PPOE" />
                </div>
                <div class="s12 m6">
                    <x-input name="infoModem" label="Info Modem" />
                </div>
            </div>
            <div class="row">
                <h5 class="small">Data Lokasi (opsional)</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="space"></div>
            <div class="grid">
                {{-- <div class="s12 m6">
                    <x-input name="koordinat" label="Koordinat" />
                </div> --}}
                <div class="s12 m6">
                    @if ($foto)
                        <img class="responsive large" src="{{ $foto->temporaryUrl() }}">
                    @else
                        @if ($oldFoto)
                            <img class="responsive large" src="{{ $oldFoto }}">
                            {{-- <img class="responsive large" src="{{ asset('public/' . $oldFoto) }}"> --}}
                        @endif
                    @endif
                    <div class="field label prefix border">
                        <i>attach_file</i>
                        <input placeholder=" " type="text">
                        <input type="file" wire:model="foto">
                        <label>Foto</label>
                        @error('foto')
                            <span class="error">{{ $message }}</span>
                        @else
                            <div wire:loading wire:target="foto">Uploading...</div>
                            <span class="helper" wire:loading.remove wire:target="foto">Ukuran maksimal 1MB</span>
                        @enderror
                    </div>
                </div>
                <div class="s12 m6">
                    <x-input name="alamat" label="Alamat" />
                </div>
            </div>
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Telepon', 'Area', 'Alamat', 'Tgl Tagihan', 'Tarif', 'Tgl Register', '']">
            @forelse($pelanggans as $pelanggan)
                <tr>
                    <td>{{ $pelanggans->firstItem() + $loop->iteration - 1 }}</td>
                    <td>{{ $pelanggan->nama }}</td>
                    <td>{{ $pelanggan->telepon }}</td>
                    <td>{{ $pelanggan->area->nama }}</td>
                    <td>{{ $pelanggan->alamat }}</td>
                    <td>{{ $pelanggan->tanggal_tagihan }}</td>
                    <td>@rupiah($pelanggan->paket->tarif + $pelanggan->biaya1 - $pelanggan->diskon)</td>
                    <td>{{ $pelanggan->tanggal_register }}</td>
                    <td>
                        <nav class="right-align">
                            <a wire:click="lihat({{ $pelanggan->id }})">
                                <i>visibility</i>
                            </a>
                            <a wire:click="edit({{ $pelanggan->id }})">
                                <i>edit</i>
                            </a>
                            <a wire:click="hapus({{ $pelanggan->id }})">
                                <i>delete</i>
                            </a>
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data.</td>
                </tr>
            @endforelse
        </x-table>
        {{ $pelanggans->links() }}

    </article>
</div>
