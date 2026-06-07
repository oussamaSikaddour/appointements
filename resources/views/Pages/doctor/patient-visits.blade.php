@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<x-default.table.link
 route="medical_files_route"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />
 <livewire:default.open-modal-button
     :title="__('modals.patient_visit.actions.add.simple')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalTitleOptions
     :$modalContent
      :$containsTinyMce
 />
<h2>@lang("pages.patient_visits.titles.main",['code'=>$parameters['code'] , "name" => $parameters['name'],])</h2>
</div>

  <livewire:default.doctor.patient-visits-table

  />

@endsection
