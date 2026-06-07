@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">

<livewire:default.open-modal-button
     :title="__('modals.bank.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
 <h2>@lang("pages.banks.titles.main")</h2>
</div>

 <livewire:default.super-admin.banks-table/>
@endsection
