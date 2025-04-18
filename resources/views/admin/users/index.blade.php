@extends('layouts.admin')
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

    <div class="mt-8 flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle">
                <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Orders</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($users as $user)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->orders_count }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <form action="{{ route("user.status",$user->id) }}" method="get" class="form-control">
                                        <div class="flex items-center gap-2">
                                            <select name="status" class="form-select rounded-md border-gray-300 text-sm" id="" onchange="this.form.submit()">
                                                <option value="1" {{ $user->is_active===1 ? 'selected' :'' }}>Active</option>
                                                <option value="0" {{ $user->is_active===0 ? 'selected' :'' }}>Inactive</option>
                                            </select>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->is_active ? 'Can Login' : 'Cannot Login' }}
                                            </span>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                <form action="{{ route('user.role',$user->id)}}" method="get" class="form-control">
                                    <select name="role" id="">
                                        <option value="customer" {{ $user->role==='customer' ? 'selected' : '' }}>customer</option>
                                        <option value="admin"{{ $user->role==='admin' ? 'selected' : ''}}>admin</option>
                                    </select>
                                    <input type="submit">
                                </form>
                                </td>
                    
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end space-x-3">
                                       
                                        @if($user->orders_count == 0)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to permanently delete this user?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @else
                                            <button type="button" 
                                                    class="text-gray-400 cursor-not-allowed" 
                                                    title="Cannot delete user with orders">
                                                Delete
                                            </button>
                                        @endif
                                    </div>
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
