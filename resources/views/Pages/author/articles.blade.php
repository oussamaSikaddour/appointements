@extends("layouts.default-layout")
@section("pageContent")

<div class="container__header">
     <livewire:default.open-modal-button
     :title="__('modals.article.actions.add')"
     classes="button--primary"
     content="<i class='fa-solid fa-plus'></i>"
     :$modalTitle
     :$modalContent
     :$containsTinyMce
 />
<h2>@lang("pages.articles.titles.main")</h2>
</div>
  <livewire:default.author.articles-table />
@endsection
