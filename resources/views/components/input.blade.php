<div class="field label @if ($icon) prefix @endif @error($name) invalid @enderror border">
    @if ($icon)
        <i>{{ $icon }}</i>
    @endif
    @if ($live)
        <input wire:model="{{ $name }}" type="{{ $type }}" placeholder=" ">
    @else
        <input wire:model.defer="{{ $name }}" type="{{ $type }}" placeholder=" ">
    @endif
    <label>{{ $label }}</label>
    @error($name)
        <span class="error">{{ $message }}</span>
    @else
        @if ($helper)
            <span class="helper">{{ $helper }}</span>
        @endif
    @enderror
</div>
