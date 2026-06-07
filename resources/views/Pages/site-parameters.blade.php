@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">
<h2>@lang('pages.site_parameters.titles.main')</h2>
</div>
<div class="form__container small forMultiForm">
 <div class="forms spForms">
   <livewire:default.super-admin.site-parameters.first-step wire:key="sp-f-s"/>
   <livewire:default.super-admin.site-parameters.last-step wire:key="sp-l-s" />
</div>
</div>
@endsection
