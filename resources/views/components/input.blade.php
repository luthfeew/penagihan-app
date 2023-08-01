<div class="field label @if ($icon) prefix @endif @error($name) invalid @enderror border">
    @if ($icon)
        <i>{{ $icon }}</i>
    @endif
    <input wire:model.defer="{{ $name }}" type="{{ $type }}" placeholder=" ">
    <label>{{ $label }}</label>
    @error($name)
        <span class="error">{{ $message }}</span>
    @else
        @if ($helper)
            <span class="helper">{{ $helper }}</span>
        @endif
    @enderror
</div>
