@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">

<livewire:default.open-modal-button
     :title="__('modals.schedule.actions.add',$modalTitleOptions)"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalTitleOptions
     :$modalContent
 />
<h2>@lang("pages.service_admin_space.titles.main")</h2>
</div>

<livewire:default.service-admin.schedules-table :$serviceId
  />
@endsection
