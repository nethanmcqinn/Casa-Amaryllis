@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 text-center">
                <div class="rounded-full bg-green-100 h-20 w-20 flex items-center justify-center mx-auto">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Order Successful!</h2>
                <p class="mt-2 text-gray-600">Thank you for your purchase.</p>
            </div>

            <div class="border-t border-gray-200 px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</h3>
                <div class="mt-4 space-y-6">
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-sm font-medium">
                            <p class="text-gray-600">Order Status:</p>
                            <p class="text-pink-600">{{ ucfirst($order->status) }}</p>
                        </div>
                    </div>

                    @foreach($order->items as $item)
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="{{ Storage::url($item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="h-16 w-16 object-cover rounded">
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                    @endforeach

                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-sm font-medium">
                            <p class="text-gray-600">Total Amount:</p>
                            <p class="text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-medium text-gray-900">Shipping Details</h4>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                            {{ $order->shipping_zipcode }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">An email confirmation has been sent to {{ auth()->user()->email }}</p>
                    <a href="{{ route('shop.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
