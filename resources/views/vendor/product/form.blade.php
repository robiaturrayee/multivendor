<form id="productForm">
@csrf

<input type="hidden" id="product_id">

<input type="text" name="name" class="form-control mb-2" placeholder="Product Name">
<textarea name="description" class="form-control mb-2"></textarea>

<div id="variation-wrapper"></div>

<button type="button" class="btn btn-success mb-2" onclick="addVariant()">+ Variant</button>

<button class="btn btn-primary">Save</button>
</form>

<script>
let vIndex=0;

function addVariant(){
    let html=`
    <div class="card mb-2 p-2">
        <div class="attributes"></div>

        <button type="button" onclick="addAttribute(this)">+ Attribute</button>

        <input type="number" name="variations[${vIndex}][price]" placeholder="Price">
        <input type="number" name="variations[${vIndex}][stock]" placeholder="Stock">
    </div>`;
    $('#variation-wrapper').append(html);
    vIndex++;
}

function addAttribute(btn){
    let variant=$(btn).closest('.card');
    let attrBox=variant.find('.attributes');
    let attrIndex=attrBox.children().length;
    let index=$('#variation-wrapper .card').index(variant);

    attrBox.append(`
    <input type="text" name="variations[${index}][attributes][${attrIndex}][name]" placeholder="Attribute">
    <input type="text" name="variations[${index}][attributes][${attrIndex}][value]" placeholder="Value">
    `);
}
</script>