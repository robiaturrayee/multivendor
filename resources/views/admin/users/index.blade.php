@extends('layouts.app')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between">
        <h5>User List</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add</a>
    </div>

    <table class="table mt-3">
        <tr><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->role }}</td>
            <td>
                <a href="{{ route('admin.users.edit',$u->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('admin.users.destroy',$u->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection