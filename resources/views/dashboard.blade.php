@extends("layouts.admin")
@section('content')
    <main class="container mx-auto px-6 py-8">
            <h2 class="text-xl font-semibold mb-4">Welcome, {{ auth()->user()->name }}</h2>
            <p class="text-gray-600">Today is {{ now()->toFormattedDateString() }}</p> 
    </main>
@endsection