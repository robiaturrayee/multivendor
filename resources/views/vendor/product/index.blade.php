@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Products</h4>
        <a href="/vendor/products/create" class="btn btn-primary">+ Add Product</a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Variations</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>
                        @foreach($p->variations as $v)
                            @foreach($v->attributes as $a)
                                {{ $a->attribute_name }}: {{ $a->attribute_value }},
                            @endforeach
                            ₹{{ $v->price }} | Stock: {{ $v->stock }} <br>
                        @endforeach
                    </td>
                    <td>
                        <a href="/vendor/products/edit/{{ $p->id }}" class="btn btn-warning btn-sm">Edit</a>
                        <button onclick="deleteProduct({{ $p->id }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

</div>

<script>
function deleteProduct(id){
    if(confirm('Delete?')){
        $.ajax({
            url:'/vendor/products/delete/'+id,
            type:'DELETE',
            success:function(){
                location.reload();
            }
        });
    }
}
</script>

@endsection