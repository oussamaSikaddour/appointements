<header class="header">
    <nav class="nav" aria-labelledby="main-nav">
        <h2 id="main-nav" class="sr-only">
            Main navigation
        </h2>

        @auth
        <div class="nav__addons">
            @canany(['admin-access', 'super-admin-access'])
                <x-default.side-bar.open-btn html_id="mainMenuDeskTopBtn" />
            @endcanany
            <livewire:default.nav-logo />
        </div>

        <ol class="nav__items">
            <x-default.nav.link
                route="user_route"
                :label="__('pages.user_space.name')"
            />

            @can('admin-access')
                <x-default.nav.link
                    route="admin_route"
                    :label="__('pages.admin_space.name')"
                />

            @endcan
            @can('establishment-admin-access')
                <x-default.nav.link
                    route="establishment_admin_route"
                    :label="__('pages.establishment_admin_space.name')"
                />
                <x-default.nav.link
                    route="services_route"
                    :label="__('pages.services.name')"
                />
            @endcan
            @can('appointments-location-admin-access')
                <x-default.nav.link
                    route="appointments_location_admin_route"
                    :label="__('pages.appointments_location_admin_space.name')"
                />
            @endcan
            @can('service-admin-access')
                <x-default.nav.link
                    route="service_admin_route"
                    :label="__('pages.service_admin_space.name')"
                />
                <x-default.nav.link
                    route="manage_appointments_location_admins_route"
                    :label="__('pages.manage_appointments_location_admins.name')"
                />
            @endcan
            @can('doctor-access')
                <x-default.nav.link
                    route="doctor_route"
                    :label="__('pages.doctor_space.name')"
                />

                <x-default.nav.link
                    route="medical_files_route"
                    :label="__('pages.medical_files.name')"
                />
            @endcan

            @can('super-admin-access')
                <x-default.nav.link
                    route="super_admin_route"
                    :label="__('pages.super_admin_space.name')"
                />

            @endcan
        </ol>

        <ol class="nav__items">
            <livewire:default.notifications-button wire:key="nb-desktop"/>
            <livewire:default.user-nav-button wire:key="unb-desktop" />
        </ol>
        @endauth

        @guest

        <div class="nav__addons">
            <livewire:default.nav-logo />
        </div>
        <ol class="nav__items">
            <x-default.nav.link
                route="LOGIN"
                :label="__('pages.login.name')"
            />
            <x-default.nav.link
                route="REGISTER"
                :label="__('pages.register.name')"
            />
        </ol>
        @endguest

        <livewire:default.lang-menu wire:key="lang-menu-desktop" />
    </nav>
</header>
