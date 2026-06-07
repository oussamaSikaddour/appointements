@extends("layouts.default-layout")
@section("pageContent")
  <div class="text-center">
    <h1 class="text-6xl font-bold text-red-600">500</h1>
    <p class="text-2xl font-semibold mt-4">Server Error</p>
    <p class="text-gray-600 mt-2">Something went wrong on our end. Please try again later.</p>
    <a href="/" class="mt-6 inline-block px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Reload</a>
  </div>
@endsection
