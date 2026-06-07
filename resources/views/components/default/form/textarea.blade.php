@props([
    'model',    // Wire model name
    'label',    // Label text for the textarea
    'html_id',  // Unique HTML ID for the textarea
    'rows' => 4,    // Default number of rows
    'cols' => 100,  // Default number of columns
    'maxlength' => 3000, // Default maximum character length
])

<div class="textarea__group">
    <textarea
        id="{{ $html_id }}"
        class="textarea"
        wire:model="{{ $model }}"
        rows="{{ $rows }}"
        cols="{{ $cols }}"
        maxlength="{{ $maxlength }}"
        placeholder="{{ $label }}"
        {{ $attributes }}
    ></textarea>
    <label for="{{ $html_id }}" class="textarea__label">{{ $label }}</label>
    @error($model)
        <div class="input__error">
            {{ $message }}
        </div>
    @enderror
</div>
