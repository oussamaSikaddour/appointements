@extends("layouts.root-layout")



@push('css')
@vite(['resources/css/default/app.css'])
@endpush

@push('js')
@vite(['resources/js/default/app.js'])
@endpush

@section("body")

<x-default.nav.for-desktop />
<x-default.nav.hamburger-button/>
<x-default.nav.for-phone  />


@canany(['super-admin-access', 'admin-access','author-access'])
<x-default.side-bar.open-btn   html_id="mainMenuPhoneBtn" class="menu__btn--phone"/>
<x-default.side-bar.menu/>
@endcanany

<main class="container">
@yield("pageContent")
</main>



<livewire:default.toast />
<livewire:default.errors-handler />
<livewire:default.modal />
<livewire:default.dialog/>
@endsection
