@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">
 <x-default.table.link route="landing_page" icon="previous" :toolTipMessage="__('toolTips.common.previous.page')" />
<h2>@lang("pages.general_infos.titles.main")</h2>
</div>

<livewire:default.super-admin.general-infos/>
@endsection
