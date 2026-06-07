@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">



     <livewire:default.open-modal-button
     :title="__('modals.user.actions.add.personnel',$modalTitleOptions)"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalTitleOptions
     :$modalContent
 />
<h2>@lang("pages.establishment_admin_space.titles.main")</h2>
</div>
  <livewire:default.users-table :$establishmentId
  />
@endsection
