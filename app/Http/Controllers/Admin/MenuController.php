<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\MenuRole;

class MenuController extends Controller
{
    public function index() {
    $menus = Menu::all();
    return view('admin.menus.index', compact('menus'));
}

public function create() {
    return view('admin.menus.create');
}

public function store(Request $request) {
    Menu::create($request->all());
    return redirect()->route('admin.menus.index');
}

public function edit($id) {
    $menu = Menu::findOrFail($id);
    return view('admin.menus.edit', compact('menu'));
}

public function update(Request $request, $id) {
    Menu::findOrFail($id)->update($request->all());
    return redirect()->route('admin.menus.index');
}

public function destroy($id) {
    Menu::destroy($id);
    return back();
}
public function getMenus()
{
    $role = auth()->user()->role;

    return \App\Models\Menu::whereHas('roles', function($q) use ($role){
        $q->where('role', $role);
    })->get();
}
}