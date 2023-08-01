<div class="field label suffix @error($name) invalid @enderror border">
    <select wire:model.defer="{{ $name }}" wire:loading.attr="disabled">
        <option value=""></option>
        @foreach ($options as $key => $value)
            <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
    </select>
    <label>{{ $label }}</label>
    <i>arrow_drop_down</i>
    @error($name)
        <span class="error">{{ $message }}</span>
    @else
        @if ($empty && count($options) == 0)
            <span class="helper">{{ $empty }}</span>
        @else
            <span class="helper">{{ $helper }}</span>
        @endif
    @enderror
</div>
