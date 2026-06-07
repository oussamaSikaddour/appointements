@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">

 <livewire:default.open-modal-button
     :title="__('modals.wilaya.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />

<h2>@lang("pages.wilayates.titles.main")</h2>

</div>


 <livewire:default.super-admin.wilayates-table />
@endsection
