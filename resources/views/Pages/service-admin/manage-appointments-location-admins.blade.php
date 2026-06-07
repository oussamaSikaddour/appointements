@extends("layouts.default-layout")
@section("pageContent")


<div class="container__header">

<h2>@lang("pages.manage_appointments_location_admins.titles.main")</h2>
</div>

<livewire:default.service-admin.appointments-location-admins :$establishmentId
  />
@endsection
