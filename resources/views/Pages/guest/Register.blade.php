@extends("layouts.default-layout")
@section("pageContent")
<div class="container__header">
<h2>@lang('pages.register.titles.main')</h2>
</div>
<div class="form__container small forMultiForm">
 <div class="forms">
   <livewire:default.guest.register.first-step wire:key="r-f-s"/>
   <livewire:default.guest.register.last-step wire:key="r-l-s" />
</div>
</div>
@endsection
