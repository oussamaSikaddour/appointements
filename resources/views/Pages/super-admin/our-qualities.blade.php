@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">

 <x-default.table.link route="landing_page" icon="previous" :toolTipMessage="__('toolTips.common.previous.page')" />

     <livewire:default.open-modal-button
     :title="__('modals.our_quality.actions.new')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
 <h2>@lang("pages.manage_about_us.titles.main")</h2>
</div>
<livewire:default.super-admin.our-qualities-table/>
@endsection
