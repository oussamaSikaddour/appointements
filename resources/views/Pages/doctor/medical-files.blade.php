@extends("layouts.default-layout")
@section("pageContent")
<div class="container__header">
<h2>@lang("pages.medical_files.titles.main")</h2>
</div>
 <livewire:default.user.medical-files-table :$doctorId  :$isForDoctor/>
@endsection
