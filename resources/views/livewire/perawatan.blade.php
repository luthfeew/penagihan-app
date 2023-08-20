<div>
    <article class="large-elevate large-padding">

        <x-heading title="Perawatan" subtitle="Biaya lain-lain" />

        <x-dialog id="perawatan" action="{{ $action }}" title="Biaya">
            <x-input name="nama" label="Keterangan" />
            <x-input name="biaya" label="Biaya (Rp)" type="number" />
            <x-input name="waktu" label="Waktu" type="date" icon="today"
            helper="{{ $waktu ? '' : '(opsional, jika kosong otomatis hari ini)' }}" />
        </x-dialog>

        <x-table :headers="['#', 'Nama', 'Biaya', 'Waktu', '']">
            @forelse ($perawatans as $perawatan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $perawatan->nama }}</td>
                    <td>@rupiah($perawatan->biaya)</td>
                    {{-- <td>{{ $perawatan->waktu }}</td> --}}
                    {{-- WAktu format d-m-y --}}
                    <td>{{ date('d-m-Y', strtotime($perawatan->waktu)) }}</td>
                    <td>
                        <nav class="right-align">
                            <a wire:click="edit({{ $perawatan->id }})">
                                <i>edit</i>
                            </a>
                            <a wire:click="hapus({{ $perawatan->id }})">
                                <i>delete</i>
                            </a>
                        </nav>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada data</td>
                </tr>
            @endforelse
        </x-table>

    </article>
</div>
