@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">
    <div class="card-header"><h4>Add Product</h4></div>

    <div class="card-body">

        <form id="productForm">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Product Name">
        <textarea name="description" class="form-control mb-2"></textarea>

        <div id="variation-wrapper"></div>

        <button type="button" class="btn btn-success mb-2" id="addVariantBtn">+ Variant</button>

        <button class="btn btn-primary">Save</button>

        </form>

    </div>
</div>

</div>

<script>

let vIndex = 0;

/* ADD VARIANT */
$('#addVariantBtn').click(function(){

    $('#variation-wrapper').append(`
    <div class="card p-2 mb-2 variant">

        <div class="d-flex justify-content-between">
            <strong>Variant</strong>
            <button type="button" class="btn btn-danger btn-sm remove-variant">X</button>
        </div>

        <div class="attributes"></div>

        <button type="button" class="btn btn-info btn-sm mb-2 add-attribute">+ Attribute</button>

        <input type="number" class="form-control mb-1 price" placeholder="Price">
        <input type="number" class="form-control mb-1 stock" placeholder="Stock">

    </div>`);

    reIndexVariants();
});

/* REMOVE VARIANT */
$(document).on('click','.remove-variant',function(){
    $(this).closest('.variant').remove();
    reIndexVariants();
});

/* ADD ATTRIBUTE */
$(document).on('click','.add-attribute',function(){

    let variant = $(this).closest('.variant');
    let attrBox = variant.find('.attributes');

    attrBox.append(`
    <div class="row mb-2 attribute">
        <div class="col">
            <input type="text" class="form-control attr-name" placeholder="Attribute">
        </div>
        <div class="col">
            <input type="text" class="form-control attr-value" placeholder="Value">
        </div>
        <div class="col-2">
            <button type="button" class="btn btn-danger btn-sm remove-attribute">X</button>
        </div>
    </div>`);

    reIndexVariants();
});

/* REMOVE ATTRIBUTE */
$(document).on('click','.remove-attribute',function(){
    $(this).closest('.attribute').remove();
    reIndexVariants();
});

/* REINDEX */
function reIndexVariants(){

    $('#variation-wrapper .variant').each(function(i){

        $(this).find('.price').attr('name', `variations[${i}][price]`);
        $(this).find('.stock').attr('name', `variations[${i}][stock]`);

        $(this).find('.attribute').each(function(j){
            $(this).find('.attr-name').attr('name', `variations[${i}][attributes][${j}][name]`);
            $(this).find('.attr-value').attr('name', `variations[${i}][attributes][${j}][value]`);
        });

    });

    vIndex = $('#variation-wrapper .variant').length;
}

/* SUBMIT */
$('#productForm').submit(function(e){
    e.preventDefault();

    if($('input[name=name]').val()==''){
        alert('Product name required'); return;
    }

    $.post('/vendor/products/store', $(this).serialize(), function(res){
        if(res.status){
            alert('Created');
            window.location='/vendor/products';
        }
    });
});

</script>

@endsection