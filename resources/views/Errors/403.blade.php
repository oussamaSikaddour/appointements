@extends("layouts.default-layout")
@section("pageContent")
  <div class="text-center">
    <h1 class="text-6xl font-bold text-red-600">403</h1>
    <p class="text-2xl font-semibold mt-4">Access Denied</p>
    <p class="text-gray-600 mt-2">You don’t have permission to access this page.</p>
    <a href="/" class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Go Home</a>
  </div>
@endsection
