@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">
    <div class="card-header"><h4>Edit Product</h4></div>

    <div class="card-body">

        <form id="productForm">
        @csrf

        <input type="hidden" id="product_id" value="{{ $id }}">

        <input type="text" name="name" class="form-control mb-2">
        <textarea name="description" class="form-control mb-2"></textarea>

        <div id="variation-wrapper"></div>

        <button type="button" class="btn btn-success mb-2" id="addVariantBtn">+ Variant</button>

        <button class="btn btn-primary">Update</button>

        </form>

    </div>
</div>

</div>

<script>

let productId = $('#product_id').val();

/* LOAD DATA */
$.get('/vendor/products/get/'+productId,function(data){

    $('input[name=name]').val(data.name);
    $('textarea[name=description]').val(data.description);

    data.variations.forEach(v=>{

        let html = `
        <div class="card p-2 mb-2 variant">

            <div class="d-flex justify-content-between">
                <strong>Variant</strong>
                <button type="button" class="btn btn-danger btn-sm remove-variant">X</button>
            </div>

            <div class="attributes"></div>

            <input type="number" class="form-control mb-1 price" value="${v.price}">
            <input type="number" class="form-control mb-1 stock" value="${v.stock}">

        </div>`;

        $('#variation-wrapper').append(html);

        let attrBox = $('#variation-wrapper > div').last().find('.attributes');

        v.attributes.forEach(a=>{
            attrBox.append(`
            <div class="row mb-2 attribute">
                <div class="col">
                    <input type="text" class="form-control attr-name" value="${a.attribute_name}">
                </div>
                <div class="col">
                    <input type="text" class="form-control attr-value" value="${a.attribute_value}">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm remove-attribute">X</button>
                </div>
            </div>`);
        });

    });

    reIndexVariants();
});

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

        <input type="number" class="form-control mb-1 price">
        <input type="number" class="form-control mb-1 stock">

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
    variant.find('.attributes').append(`
    <div class="row mb-2 attribute">
        <div class="col"><input class="form-control attr-name"></div>
        <div class="col"><input class="form-control attr-value"></div>
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
}

/* UPDATE */
$('#productForm').submit(function(e){
    e.preventDefault();

    $.post('/vendor/products/update/'+productId, $(this).serialize(), function(res){
        if(res.status){
            alert('Updated');
            window.location='/vendor/products';
        }
    });
});

</script>

@endsection