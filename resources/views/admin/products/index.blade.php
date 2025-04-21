@extends('layouts.admin')
@extends('layouts.base')
<?php
// dd($dataTable);
?>
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
    <div class="content">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    <h2 class="mb-4">User List</h2>
    <br>
    <hr>
    <div class="card-body">
        {{$dataTable->table()}}
    </div>
</div>



@push('scripts')
    {{ $dataTable->scripts() }}
@endpush 
   
</div>
@endsection