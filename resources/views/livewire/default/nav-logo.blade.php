
<a
    class="nav__logo"
    href="{{ route($route) }}"
    tabindex="0"
    aria-label="App Logo"
    x-on:logo-updated.window="$wire.$refresh()"
>
    <img src="{{ $this->logoUrl }}" alt="App Logo">
</a>
