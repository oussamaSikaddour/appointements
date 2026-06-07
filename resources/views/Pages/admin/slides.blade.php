@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<x-default.table.link
 route="sliders_route"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />
 <livewire:default.open-modal-button
     :title="__('modals.slide.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
      :$containsTinyMce
 />
<h2>@lang("pages.slider.titles.main",['name'=>$parameters['name']])</h2>
</div>
  <livewire:default.admin.slides-table
    :sliderId="$parameters['id']"
  />
@endsection
