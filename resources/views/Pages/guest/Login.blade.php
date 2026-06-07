@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">
<h2>@lang('pages.login.titles.main')</h2>
</div>
    <div class="form__container small ">
<livewire:default.guest.login />
</div>
@endsection
