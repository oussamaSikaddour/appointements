@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<x-default.table.link
 route="admin_route"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />
 <livewire:default.open-modal-button
     :title="__('modals.user.actions.add.personnel', ['name'=> $parameters['acronym']])"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalTitleOptions
     :$modalContent
 />
<h2>@lang("pages.establishment.titles.main",['acronym'=>$parameters['acronym']])</h2>
</div>

  <livewire:default.admin.establishment-details
    :id="$parameters['id']"
  />
  <livewire:default.users-table
    :establishmentId="$parameters['id']"
  />
@endsection
