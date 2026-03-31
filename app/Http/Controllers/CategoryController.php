<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
    return view('category.index');
}

public function list(){
    return Category::with('parent')->get();
}

public function store(Request $request){
    Category::create($request->all());
    return response()->json(['status'=>true]);
}

public function edit($id){
    return Category::findOrFail($id);
}

public function update(Request $request,$id){
    Category::findOrFail($id)->update($request->all());
    return response()->json(['status'=>true]);
}

public function delete($id){
    Category::findOrFail($id)->delete();
    return response()->json(['status'=>true]);
}
}
