@extends('layouts.app')

@section('content')
<div class="card p-3">
    <h5>{{ isset($user) ? 'Edit' : 'Add' }} User</h5>

    <form method="POST" action="{{ isset($user) ? route('admin.users.update',$user->id) : route('admin.users.store') }}">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <input name="name" value="{{ $user->name ?? '' }}" class="form-control mb-2" placeholder="Name">
        <input name="email" value="{{ $user->email ?? '' }}" class="form-control mb-2" placeholder="Email">
        <input name="password" class="form-control mb-2" placeholder="Password">

        <select name="role" class="form-control mb-2">
            <option value="admin">Admin</option>
            <option value="vendor">Vendor</option>
        </select>

        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection