<div class="row">
    <div class="max">
        <h5>{{ $title }}</h5>
        <p>{{ $subtitle }}</p>
    </div>
    @if ($action != 'false')
        <div>
            <button class="extend border square round" wire:click="tambah">
                <i>add</i>
                <span>Tambah</span>
            </button>
        </div>
    @endif
</div>
