@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">



     <livewire:default.open-modal-button
     :title="__('modals.user.actions.add.user')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
<h2>@lang("pages.super_admin_space.titles.main")</h2>
</div>
 <livewire:default.users-table/>
@endsection
