<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
   public function index() {
    $users = User::latest()->get();
    return view('admin.users.index', compact('users'));
}

public function create() {
    return view('admin.users.create');
}

public function store(Request $request) {
    User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
        'role'=>$request->role,
    ]);
    return redirect()->route('admin.users.index');
}

public function edit($id) {
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->all());
    return redirect()->route('admin.users.index');
}

public function destroy($id) {
    User::destroy($id);
    return back();
}

}
