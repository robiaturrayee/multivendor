@extends('layouts.app')

@section('content')

<div class="container">

<!-- FORM -->
<div class="card mb-3">
    <div class="card-header">
        <h5 id="formTitle">Add Category</h5>
    </div>

    <div class="card-body">

        <form id="categoryForm">
        @csrf

        <input type="hidden" id="category_id">

        <input type="text" name="name" class="form-control mb-2" placeholder="Category Name">

        <select name="parent_id" class="form-control mb-2">
            <option value="">Main Category</option>
        </select>

        <button class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>

        </form>

    </div>
</div>

<!-- TABLE -->
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="categoryTable"></tbody>

        </table>

    </div>
</div>

</div>

<script>

/* LOAD DATA */
function loadCategories(){
    $.get('/categories/list', function(data){

        let html = '';
        let options = '<option value="">Main Category</option>';

        data.forEach(c=>{

            if(!c.parent_id){
                options += `<option value="${c.id}">${c.name}</option>`;
            }

            html += `
            <tr>
                <td>${c.name}</td>
                <td>${c.parent ? c.parent.name : 'Main'}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editCategory(${c.id})">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteCategory(${c.id})">Delete</button>
                </td>
            </tr>`;
        });

        $('#categoryTable').html(html);
        $('select[name=parent_id]').html(options);
    });
}

loadCategories();

/* SAVE */
$('#categoryForm').submit(function(e){
    e.preventDefault();

    let id = $('#category_id').val();
    let url = id ? '/categories/update/'+id : '/categories/store';

    $.post(url, $(this).serialize(), function(){
        loadCategories();
        resetForm();
    });
});

/* EDIT */
function editCategory(id){
    $.get('/categories/edit/'+id,function(data){

        $('#formTitle').text('Edit Category');

        $('#category_id').val(data.id);
        $('input[name=name]').val(data.name);
        $('select[name=parent_id]').val(data.parent_id);
    });
}

/* DELETE */
function deleteCategory(id){
    if(confirm('Delete?')){
        $.ajax({
            url:'/categories/delete/'+id,
            type:'DELETE',
            success:function(){
                loadCategories();
            }
        });
    }
}

/* RESET */
function resetForm(){
    $('#categoryForm')[0].reset();
    $('#category_id').val('');
    $('#formTitle').text('Add Category');
}

</script>

@endsection