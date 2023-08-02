<div>
    <div class="space"></div>
    @if ($paginator->hasPages())
        <nav class="no-space center-align">
            @if ($paginator->onFirstPage())
                {{-- <button class="border left-round" disabled>
                    <i>first_page</i>
                </button> --}}
            @else
                <button class="border no-round" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                    <i>navigate_before</i>
                </button>
            @endif
            @if ($paginator->hasMorePages())
                <button class="border no-round" wire:click="nextPage" wire:loading.attr="disabled" rel="next">
                    <i>navigate_next</i>
                </button>
            @else
                {{-- <button class="border right-round" disabled>
                    <i>last_page</i>
                </button> --}}
            @endif
        </nav>
    @endif
</div>
