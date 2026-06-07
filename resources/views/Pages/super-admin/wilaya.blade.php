@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<x-default.table.link
 route="wilayates"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />
 <livewire:default.open-modal-button
     :title="__('modals.daira.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
<h2>@lang("pages.wilaya.titles.main",['code'=>$parameters['code']])</h2>
</div>


  <livewire:default.super-admin.dairates-table
    :wilayaId="$parameters['id']"
    :wilayaCode="$parameters['code']"
  />
@endsection
