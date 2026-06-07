@extends("layouts.default-layout")
@section("pageContent")
<div class="container__header">
<h2>@lang('pages.change_password.titles.main')</h2>
</div>
<div class="form__container small">
<livewire:default.user.change-password />
</div>
@endsection
