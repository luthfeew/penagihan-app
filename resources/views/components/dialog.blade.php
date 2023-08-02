<dialog class="{{ $size }}" id="{{ $id }}" wire:ignore.self>
    <header class="fixed">
        <div class="space"></div>
        <h5 class="no-margin">{{ Str::ucfirst($action) }} {{ $title }}</h5>
        <div class="space"></div>
    </header>
    {{-- <div class="grid">
        <div class="s10">
            <h5>{{ Str::ucfirst($action) }} {{ $title }}</h5>
        </div>
        <div class="s2"><a wire:loading.class="loader small"></a></div>
    </div> --}}

    <form @if ($action == 'lihat') inert @endif wire:submit.prevent="simpan">
        {{ $slot }}
        @if ($action != '' && $action != 'lihat')
            <nav class="right-align">
                <button type="button" class="border" data-ui="#{{ $id }}">Tutup</button>
                <button type="submit">{{ $submit }}</button>
            </nav>
        @endif
    </form>
    @if ($action == 'lihat' || $action == '')
        <nav class="right-align">
            <button type="button" class="border" data-ui="#{{ $id }}">Tutup</button>
        </nav>
    @endif
</dialog>
