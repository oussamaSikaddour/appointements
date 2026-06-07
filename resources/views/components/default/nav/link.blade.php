<li class="nav__item {{ $active }}">
    <a class="nav__link"
       @if ($active) aria-current="page" @endif
       href="{{ $routeUrl }}">
        {{ $label }}
        @if ($span)
            <span>{!! $span !!}</span>
        @endif
    </a>
</li>
