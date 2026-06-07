@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">

 <livewire:default.open-modal-button
     :title="__('modals.service.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle


     :$modalContent
 />
<h2>@lang("pages.services.titles.main")</h2>
</div>
  <livewire:default.establishment-admin.services-table :$establishmentId
  />
@endsection
