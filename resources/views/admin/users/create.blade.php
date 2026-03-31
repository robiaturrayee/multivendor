@extends('layouts.app')

@section('content')

<div class="card p-3">
    <h5>Add User</h5>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-2">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="admin">Admin</option>
                <option value="vendor">Vendor</option>
                <option value="customer">Customer</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

@endsection