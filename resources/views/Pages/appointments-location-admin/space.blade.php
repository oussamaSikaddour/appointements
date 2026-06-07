@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">
<h2>@lang("pages.appointments_location_admin_space.titles.main")</h2>
</div>

  <livewire:default.confirmed-appointments-table :$appointmentsLocationId
  />
@endsection
