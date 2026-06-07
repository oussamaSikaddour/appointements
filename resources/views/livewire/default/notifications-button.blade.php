<li class="nav__item nav__item--dropDown" wire:poll.60s="refreshNotifications">
    <div id="notifications-btn"
        tabindex="0"
        class="nav__btn nav__btn--dropdown"
        aria-expanded="false"
        aria-controls="subItems"
        aria-label="Show Notifications menu"
        aria-labelledby="notifications-btn">
        <i class="fa-solid fa-bell" aria-hidden="true"></i>

        @if ($notificationsCount > 0)
            <span class="nav__item__badge">{{ $notificationsCount }}</span>
        @endif
    </div>

    @if ($notificationsCount > 0)
        <ul id="subItems" class="nav__items--sub" hidden role="menu">
            @foreach ($notifications as $n)
                @php
                    $message = 'notifications.reservation.' . $n->message;
                @endphp
                <li role="none" wire:click="manageNotification({{ $n->id }})">
                    @lang($message)
                </li>
            @endforeach
        </ul>
    @endif
</li>

@push('scripts')
<script>
    $wire.on('refresh-notifications', () => {
        $wire.$refresh();
    })
</script>
@endpush
