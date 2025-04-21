@extends('layouts.admin')
@extends('layouts.base')
<?php
?>
@section('admin-content')
<div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Product Reviews</h1>
            <p class="mt-2 text-sm text-gray-700">Manage customer reviews and feedback</p>
        </div>
    </div>

<div class="content">
    <div class="card-body">
        {{$dataTable->table()}}
    </div>
</div>


@push('scripts')
    {{ $dataTable->scripts() }}
@endpush


@endsection
