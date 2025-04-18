@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>
        
        <!-- Product Summary -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <div class="flex items-center space-x-4">
                <img src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-24 h-24 object-cover rounded-lg">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-500">{{ Str::limit($product->description, 100) }}</p>
                    <p class="text-lg font-bold text-pink-600 mt-2">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Checkout Form -->
        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <!-- Shipping Information -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Shipping Address</label>
                        <input type="text" name="shipping_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="shipping_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="shipping_state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ZIP Code</label>
                        <input type="text" name="shipping_zipcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500" required>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="radio" id="card" name="payment_method" value="card" class="h-4 w-4 text-pink-600 focus:ring-pink-500" required>
                        <label for="card" class="ml-3 block text-sm font-medium text-gray-700">Credit/Debit Card</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="cash" name="payment_method" value="cash_on_delivery" class="h-4 w-4 text-pink-600 focus:ring-pink-500">
                        <label for="cash" class="ml-3 block text-sm font-medium text-gray-700">Cash on Delivery</label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Subtotal</span>
                    <span>${{ number_format($product->price, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mb-4">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="flex justify-between text-lg font-semibold text-gray-900 pt-4 border-t">
                    <span>Total</span>
                    <span>${{ number_format($product->price, 2) }}</span>
                </div>
            </div>

            <button type="submit" class="w-full bg-pink-600 text-white py-3 px-4 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition-colors duration-200">
                Place Order
            </button>
        </form>
    </div>
</div>
@endsection
