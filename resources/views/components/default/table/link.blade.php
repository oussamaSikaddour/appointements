<button class="button rounded button--primary {{ $toolTipMessage ? 'hasTooltip' : '' }}">
    @if ($toolTipMessage)
        <span class="toolTip" role="tooltip" aria-label="{{ $toolTipMessage }}">
            {{ $toolTipMessage }}
        </span>
    @endif

    <a role="menuitem" href="{{ $routeUrl }}" @if ($newTab) target="_blank" @endif>
        <span>
            @if ($iconHtml)
                {!! $iconHtml !!}
            @endif
        </span>
    </a>
</button>
