<div class="select__group">
    <div>
        <label for="{{ $htmlId }}">{{ $label }}:</label>
        <div class="select">
            <select
                id="{{ $htmlId }}"
                {{ $attributes->merge(['class' => 'select__input']) }}
                wire:model{{ $type === 'filter' ? '.live' : '' }}="{{ $model }}"
            >
                @foreach ($data as $value => $option)
                    <option value="{{ $value }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if ($showError)
        @error($model)
            <div class="input__error">{{ $message }}</div>
        @enderror
    @endif
</div>
