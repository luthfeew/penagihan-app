<div>
    <article>

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
                    <x-input name="tglTagihan" label="Tanggal Tagihan" type="number" />
                </div>
                <div class="s12 m4">
                    <x-input name="tglIsolir" label="Tanggal Isolir" type="number" helper="(opsional)" />
                </div>
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
            <details>
                <summary>Tampilkan</summary>
                <div class="grid">
                    <div class="s12 m6">
                        <x-input name="tambahan1" label="Tambahan 1" />
                    </div>
                    <div class="s12 m6">
                        <x-input name="biaya1" label="Biaya 1" />
                    </div>
                    <div class="s12 m6">
                        <x-input name="tambahan2" label="Tambahan 2" />
                    </div>
                    <div class="s12 m6">
                        <x-input name="biaya2" label="Biaya 2" />
                    </div>
                    <div class="s12 m6">
                        <x-input name="diskon" label="Diskon" />
                    </div>
                </div>
            </details>
            <div class="row">
                <h5 class="small">Data Modem (opsional)</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="space"></div>
            <details>
                <summary>Tampilkan</summary>
                <div class="grid">
                    <div class="s12 m6">
                        <x-input name="ppoe" label="PPOE" />
                    </div>
                    <div class="s12 m6">
                        <x-input name="infoModem" label="Info Modem" />
                    </div>
                </div>
            </details>
            <div class="row">
                <h5 class="small">Data Lokasi (opsional)</h5>
                <div class="small-divider max"></div>
            </div>
            <div class="space"></div>
            <div class="grid">
                <div class="s12 m6">
                    <x-input name="alamat" label="Alamat" />
                </div>
                {{-- <div class="s12 m6">
                    <x-input name="koordinat" label="Koordinat" />
                </div> --}}
                <div class="s12 m6">
                    @if ($foto)
                        <img class="responsive small" src="{{ $foto->temporaryUrl() }}">
                    @else
                        @if ($oldFoto)
                            <img class="responsive small" src="{{ $oldFoto }}">
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
            </div>
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Telepon', 'Area', 'Tgl Tagihan', 'Tarif', '']">
            @forelse($pelanggans as $pelanggan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pelanggan->nama }}</td>
                    <td>{{ $pelanggan->telepon }}</td>
                    <td>{{ $pelanggan->area->nama }}</td>
                    <td>{{ $pelanggan->tanggal_tagihan }}</td>
                    <td>@rupiah($pelanggan->paket->tarif)</td>
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
                    <td colspan="7">Tidak ada data.</td>
                </tr>
            @endforelse
        </x-table>

    </article>
</div>
