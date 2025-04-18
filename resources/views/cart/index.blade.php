@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Your Shopping Cart</h1>


    @if(auth()->user()->carts()->count() > 0)

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul class="divide-y divide-gray-200">
                @foreach(auth()->user()->carts as $item)

                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->product->name }}
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-gray-500 mr-4">
                                    {{ $item->quantity }} × ${{ number_format($item->product->price, 2) }}
                                </span>
                                <span class="font-medium">
                                    ${{ number_format($item->quantity * $item->product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="px-4 py-4 sm:px-6 bg-gray-50 text-right">
                <a href="{{ route('checkout') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">Your cart is empty</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Continue Shopping
            </a>
        </div>
    @endif
