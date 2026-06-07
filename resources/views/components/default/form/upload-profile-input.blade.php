@props(['src', 'model', 'label'])

<div class="form__upload__img">
    <div class="upload__group" role="input" tabindex="0">
        <img
            src="{{ $src }}"
            alt="{{ $label }}"
            class="upload__preview"
        >
        <span class="button rounded">
            <i class="fa-solid fa-image"></i>
        </span>
        <input
            wire:model="{{ $model }}"
            type="file"
            accept="image/*"
            class="upload__input"
        />
    </div>
</div>
