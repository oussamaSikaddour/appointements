@props(['model', 'htmlId', 'value', 'label' => '', 'live' => false])

<div class="check-box" id="checkbox-container">
    <input
        @if($live)
            wire:model.live="{{ $model }}"
        @else
            wire:model="{{ $model }}"
        @endif
        wire:key="{{ $model }}"
        type="checkbox"
        value="{{ $value }}"
        id="{{ $htmlId }}"
        role="checkbox"
         aria-checked="{{ $model ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => 'checkbox-input']) }}
    />
    <label for="{{ $htmlId }}" tabindex="0" wire:target="{{ $model }}">
        {{ $label }}
    </label>
</div>
