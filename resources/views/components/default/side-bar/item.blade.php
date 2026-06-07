<li role="presentation" class="menu__item {{ $activeClass }}">
    <a role="menuitem" href="{{ $routeUrl }}" tabindex="0">
        <!-- Route display name -->
        {{ $routeName }}

        <!-- Icon display -->
        @if ($iconHtml)
            <span class="menu__icon">
                {!! $iconHtml !!}
            </span>
        @endif

        <!-- Badge display (if provided) -->
        @if ($badge)
            <x-default.badge :badge="$badge" class="{{ $badgeClass }}" />
        @endif
    </a>
</li>
