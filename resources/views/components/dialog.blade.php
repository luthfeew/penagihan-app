<dialog class="{{ $size }}" id="{{ $id }}" wire:ignore.self>
    <div class="grid">
        <div class="s10">
            <h5>{{ Str::ucfirst($action) }} {{ $title }}</h5>
        </div>
        <div class="s2"><a wire:loading.class="loader small"></a></div>
    </div>
    <div class="space"></div>

    <form wire:submit.prevent="simpan">
        {{ $slot }}
        <nav class="right-align">
            <button type="button" class="border" data-ui="#{{ $id }}">Tutup</button>
            <button type="submit">Simpan</button>
        </nav>
    </form>
</dialog>
