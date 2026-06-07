@extends("layouts.default-layout")
@section("pageContent")
  <div class="text-center">
    <h1 class="text-6xl font-bold text-orange-500">429</h1>
    <p class="text-2xl font-semibold mt-4">Too Many Requests</p>
    <p class="text-gray-600 mt-2">You’re making requests too quickly. Please slow down.</p>
    <a href="/" class="mt-6 inline-block px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">Try Again</a>
  </div>
@endsection
