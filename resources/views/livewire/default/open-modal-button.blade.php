
<button
    class="button {{ $classes }} modal__opener {{ $toolTipMessage !== '' ? 'hasTooltip' : '' }}"
    wire:click="openModal"
    aria-haspopup="true"
    aria-expanded="false"
>
    @if ($toolTipMessage)
        <span
            class="toolTip"
            role="tooltip"
            aria-label="{{ $toolTipMessage }}"
        >
            {{ $toolTipMessage }}
        </span>
    @endif

    {{ $title }}
    {!! $content !!}
</button>
