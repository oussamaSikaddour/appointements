@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">
<h2>@lang("pages.messages.titles.main")</h2>
</div>

<livewire:default.super-admin.visitors-messages-table/>
@endsection
