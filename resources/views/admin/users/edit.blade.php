@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    
    <form action="{{ route('admin.users.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">User Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $users->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $users->email) }}" required>
        </div>

       
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('admin.users.index') }}" class=" btn-secondary">Cancel</a>

       
    </form>

    <form action="{{ route('admin.users.destroy', $users->id) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete User</button>
    </form>
</div>
@endsection