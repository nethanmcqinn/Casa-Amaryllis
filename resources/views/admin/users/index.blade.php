@extends('layouts.admin')
@extends('layouts.base')

<?php
 //dd(    $users);
?>
@section('admin-content')
<div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Users</h1>
            <p class="mt-2 text-sm text-gray-700">Manage your users and their permissions</p>
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
