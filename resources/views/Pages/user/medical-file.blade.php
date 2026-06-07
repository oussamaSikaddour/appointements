@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<x-default.table.link
 route="user_route"
 icon="previous"
 :toolTipMessage="__('toolTips.common.previous.page')"
  />
 <livewire:default.open-modal-button
     :title="__('modals.appointment.actions.add.simple')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
 />
<h2>@lang("pages.medical_file.titles.main",['code'=>$parameters['code'] , "name" => $parameters['name'],])</h2>
</div>

  <livewire:default.confirmed-appointments-table

    :patientId="$parameters['id']"
  />

@endsection
