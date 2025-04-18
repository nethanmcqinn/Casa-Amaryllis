@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Cart Summary -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                <div class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <div class="py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-16 w-16 flex-shrink-0">
                                    <img src="{{ Storage::url($item->product->image) }}" 
                                         alt="{{ $item->product->name }}"
                                         class="h-16 w-16 rounded-md object-cover">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-gray-900">
                                ${{ number_format($item->quantity * $item->product->price, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>Total</p>
                        <p>${{ number_format($total, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Shipping Information -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h2>
                <div class="grid grid-cols-1 gap-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Shipping Address</label>
                        <input type="text" name="shipping_address" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="shipping_city" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="shipping_state" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ZIP Code</label>
                        <input type="text" name="shipping_zipcode" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="radio" id="cod" name="payment_method" value="cash_on_delivery" required
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300">
                        <label for="cod" class="ml-3 block text-sm font-medium text-gray-700">
                            Cash on Delivery
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-pink-600 text-white px-6 py-3 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                    Place Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
