<button
    id="btn-{{ $htmlId }}"
    aria-haspopup="true"
    aria-expanded="false"
    aria-controls="tooltip-{{ $htmlId }}"
    class="button rounded hasTooltip"
    wire:click="{{ $function }}({{ implode(',', $parameters) }})">

    <span
        id="tooltip-{{ $htmlId }}"
        class="toolTip"
        role="tooltip"
        aria-label="{{ $ariaLabel }}">
        {{ $ariaLabel }}
    </span>

    {!! $iconHtml !!}
</button>
