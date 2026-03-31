<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationAttribute;
use DB;

class ProductController extends Controller
{
    // public function index()
    // {
    //     return view('vendor.product.index');
    // }

    // public function list()
    // {
    //     return Product::with('variations.attributes')
    //         ->where('user_id', auth()->id())
    //         ->get();
    // }

    // public function store(Request $request)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $product = Product::create([
    //             'user_id' => auth()->id(),
    //             'name' => $request->name,
    //             'description' => $request->description,
    //         ]);

    //         foreach ($request->variations as $variation) {

    //             $variant = ProductVariation::create([
    //                 'product_id' => $product->id,
    //                 'price' => $variation['price'],
    //                 'stock' => $variation['stock'],
    //             ]);

    //             foreach ($variation['attributes'] as $attr) {
    //                 VariationAttribute::create([
    //                     'product_variation_id' => $variant->id,
    //                     'attribute_name' => $attr['name'],
    //                     'attribute_value' => $attr['value'],
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['status'=>true,'message'=>'Created']);

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    //     }
    // }

    // public function edit($id)
    // {
    //     return Product::with('variations.attributes')->findOrFail($id);
    // }

    // public function update(Request $request, $id)
    // {
    //     DB::beginTransaction();

    //     try {
    //         $product = Product::findOrFail($id);

    //         $product->update([
    //             'name'=>$request->name,
    //             'description'=>$request->description
    //         ]);

    //         foreach ($product->variations as $v) {
    //             $v->attributes()->delete();
    //             $v->delete();
    //         }

    //         foreach ($request->variations as $variation) {

    //             $variant = ProductVariation::create([
    //                 'product_id'=>$product->id,
    //                 'price'=>$variation['price'],
    //                 'stock'=>$variation['stock'],
    //             ]);

    //             foreach ($variation['attributes'] as $attr) {
    //                 VariationAttribute::create([
    //                     'product_variation_id'=>$variant->id,
    //                     'attribute_name'=>$attr['name'],
    //                     'attribute_value'=>$attr['value'],
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //         return response()->json(['status'=>true,'message'=>'Updated']);

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json(['status'=>false,'message'=>$e->getMessage()]);
    //     }
    // }

    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);

    //     foreach ($product->variations as $v) {
    //         $v->attributes()->delete();
    //         $v->delete();
    //     }

    //     $product->delete();

    //     return response()->json(['status'=>true]);
    // }

  public function index_old()
{
    $products = Product::with('variations.attributes')
        ->where('user_id', auth()->id())
        ->get();

    return view('vendor.product.index', compact('products'));
}

    public function list()
    {
        return Product::with('variations.attributes')
            ->where('user_id', auth()->id())
            ->get();
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $product = Product::create([
                'user_id'=>auth()->id(),
                'name'=>$request->name,
                'description'=>$request->description,
            ]);

            foreach($request->variations as $v){

                $variant = ProductVariation::create([
                    'product_id'=>$product->id,
                    'price'=>$v['price'],
                    'stock'=>$v['stock']
                ]);

                foreach($v['attributes'] as $a){
                    VariationAttribute::create([
                        'product_variation_id'=>$variant->id,
                        'attribute_name'=>$a['name'],
                        'attribute_value'=>$a['value']
                    ]);
                }
            }

            DB::commit();
            return response()->json(['status'=>true]);

        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false]);
        }
    }
public function index()
{
    $products = Product::with('variations.attributes')
        ->where('user_id', auth()->id())
        ->get();

    return view('vendor.product.index', compact('products'));
}

public function create()
{
    return view('vendor.product.create');
}

public function editPage($id)
{
    return view('vendor.product.edit', compact('id'));
}

public function edit($id)
{
    return Product::with('variations.attributes')->findOrFail($id);
}

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        foreach($product->variations as $v){
            $v->attributes()->delete();
            $v->delete();
        }

        foreach($request->variations as $v){

            $variant = ProductVariation::create([
                'product_id'=>$product->id,
                'price'=>$v['price'],
                'stock'=>$v['stock']
            ]);

            foreach($v['attributes'] as $a){
                VariationAttribute::create([
                    'product_variation_id'=>$variant->id,
                    'attribute_name'=>$a['name'],
                    'attribute_value'=>$a['value']
                ]);
            }
        }

        return response()->json(['status'=>true]);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        foreach($product->variations as $v){
            $v->attributes()->delete();
            $v->delete();
        }

        $product->delete();

        return response()->json(['status'=>true]);
    }
}