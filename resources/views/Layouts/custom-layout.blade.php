@extends("layouts.root-layout")

@push('css')
@vite(['resources/css/custom/app.css'])
@endpush

@push('js')
@vite(['resources/js/custom/app.js'])
@endpush

@section("body")
@yield("pageContent")
@endsection
