@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <img class="h-96 w-full object-cover md:w-96" src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
            </div>
            <div class="p-8">
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-2 text-gray-600">{{ $product->description }}</p>
                <div class="mt-4">
                    <span class="text-xl font-bold text-pink-600">${{ number_format($product->price, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
