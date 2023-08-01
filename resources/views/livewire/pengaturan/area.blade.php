<div>
    <article class="border">

        <x-heading title="Area" subtitle="Daftar area yang terdaftar" />

        <x-dialog id="area" action="{{ $action }}" title="Area">
            <x-input name="nama" label="Nama Area" />
        </x-dialog>

        <x-table :headers="['#', 'Area', 'Pelanggan Terdaftar', '']">
            @forelse ($areas as $area)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $area->nama }}</td>
                    <td>{{ $area->pelanggan->count() }}</td>
                    <td>
                        <nav class="right-align">
                            <a wire:click="edit({{ $area->id }})">
                                <i>edit</i>
                            </a>
                            @if ($area->pelanggan->count() == 0)
                                <a wire:click="delete({{ $area->id }})">
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
