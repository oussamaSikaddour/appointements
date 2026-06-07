@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">

<x-default.table.link
 route="menus_route"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />


     <livewire:default.open-modal-button
     :title="__('modals.external_link.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />

   <h2>@lang("pages.menu.titles.main",['title'=>$parameters['title']])</h2>
</div>
  <livewire:default.admin.external-links-table
    :menuId="$parameters['id']"
  />
@endsection
