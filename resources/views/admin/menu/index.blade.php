@extends('layouts.app')

@section('content')
<div class="card p-3">
    <div class="d-flex justify-content-between">
        <h5>Menus</h5>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">+ Add</a>
    </div>

    <table class="table mt-3">
        <tr><th>Title</th><th>Route</th><th>Action</th></tr>

        @foreach($menus as $m)
        <tr>
            <td>{{ $m->title }}</td>
            <td>{{ $m->route }}</td>
            <td>
                <a href="{{ route('admin.menus.edit',$m->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('admin.menus.destroy',$m->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection