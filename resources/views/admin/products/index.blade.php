@extends('layouts.admin')

@section('admin-content')
<div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Flower Products</h1>
            <p class="mt-2 text-sm text-gray-700">Manage your flower shop's product inventory</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-pink-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 sm:w-auto">
                Add New Flower
            </a>
        </div>
    </div>
    
    <div class="mt-8 flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Flower Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Category</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Stock</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($products as $product)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0">
                                            @if($product->image)
                                                <img class="h-12 w-12 rounded-lg object-cover" 
                                                     src="{{ Storage::url($product->image) }}" 
                                                     alt="{{ $product->name }}"
                                                     onerror="this.src='{{ asset('images/placeholder.jpg') }}'; this.onerror=null;">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-pink-100 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">${{ number_format($product->price, 2) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $product->stock }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-pink-600 hover:text-pink-900 mr-4">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this flower?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection