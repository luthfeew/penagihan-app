<div>
    <article>

        <x-heading title="Paket" subtitle="Daftar paket yang tersedia" />

        <x-dialog id="paket" action="{{ $action }}" title="Paket">
            <x-input name="nama" label="Nama Paket" />
            <x-input name="tarif" label="Tarif" type="number" />
            <x-input name="keterangan" label="Keterangan" />
        </x-dialog>

        <x-table :headers="['#', 'Paket', 'Tarif', '']">
            @forelse ($pakets as $paket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $paket->nama }}</td>
                    <td>@rupiah($paket->tarif)</td>
                    <td>
                        <nav class="right-align">
                            <a wire:click="edit({{ $paket->id }})">
                                <i>edit</i>
                            </a>
                            @if ($paket->pelanggan->count() == 0)
                                <a wire:click="hapus({{ $paket->id }})">
                                    <i>delete</i>
                                </a>
                            @endif
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Tidak ada data</td>
                </tr>
            @endforelse
        </x-table>

    </article>
</div>
