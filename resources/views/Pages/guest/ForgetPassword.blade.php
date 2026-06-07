@extends("layouts.default-layout")
@section("pageContent")
<div class="container__header">
<h2>@lang('pages.forgot_password.titles.main')</h2>
</div>
<div class="form__container small forMultiForm">
 <div class="forms fpForms">
   <livewire:default.guest.forgot-password.first-step wire:key="fp-f-s"/>
   <livewire:default.guest.forgot-password.last-step wire:key="fp-l-s" />
</div>
</div>
@endsection
