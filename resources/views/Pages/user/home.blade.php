@extends("layouts.default-layout")
@section("pageContent")
<div class="container__header">
<livewire:default.open-modal-button
     :title="__('modals.medical_file.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
<h2>@lang("pages.user_space.titles.main")</h2>
</div>
 <livewire:default.user.medical-files-table/>
@endsection
