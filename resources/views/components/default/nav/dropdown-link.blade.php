<li class="nav__item nav__item--dropDown">
    <div
        id="subNav-btn"
        tabindex="0"
        class="nav__btn nav__btn--dropdown"
        aria-expanded="false"
        aria-controls="subItems"
        aria-label="Show user menu"
        aria-labelledby="subNav-btn"
    >
        {!! $dropdownLink !!} <!-- Render the dropdown trigger HTML -->
    </div>
    <ul
        id="subItems"
        class="nav__items--sub"
        role="menu"
    >
        {!! $renderedItems !!} <!-- Render the dropdown items HTML -->
        {{ $slot }} <!-- Render additional items passed via the slot -->
    </ul>
</li>
