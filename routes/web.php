<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/categories/list', [CategoryController::class,'list']);
Route::get('/categories/', [CategoryController::class,'list']);

Route::post('/categories/store', [CategoryController::class,'store']);
Route::get('/categories/edit/{id}', [CategoryController::class,'edit']);
Route::post('/categories/update/{id}', [CategoryController::class,'update']);
Route::delete('/categories/delete/{id}', [CategoryController::class,'delete']);





Route::get('/get-menus', [MenuController::class,'getMenus']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ================= PROFILE =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ================= ADMIN =================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Menu
        Route::get('/menus', [MenuController::class,'index']);
    Route::get('/menus/list', [MenuController::class,'list']);

    Route::post('/menus/store', [MenuController::class,'store']);
    Route::get('/menus/edit/{id}', [MenuController::class,'edit']);
    Route::post('/menus/update/{id}', [MenuController::class,'update']);
    Route::delete('/menus/delete/{id}', [MenuController::class,'destroy']);

        // Users
        // Route::get('/users', [UserController::class, 'index']);
        // Route::get('/users/list', [UserController::class, 'list']);

        // Route::post('/users/store', [UserController::class, 'store']);
        // Route::get('/users/edit/{id}', [UserController::class, 'edit']);
        // Route::post('/users/update/{id}', [UserController::class, 'update']);
        // Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);
        Route::resource('users', UserController::class);




        Route::get('/categories', [CategoryController::class,'index']);

    });


// ================= VENDOR =================
Route::prefix('vendor')
    ->name('vendor.')
    ->middleware(['auth', 'role:vendor'])
    ->group(function () {

        Route::get('/dashboard', [VendorController::class, 'index'])->name('dashboard');

    //     Route::get('/products', [ProductController::class, 'index']);

    // Route::get('/products/list', [ProductController::class, 'list']);
    // Route::post('/products/store', [ProductController::class, 'store']);
    // Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
    // Route::post('/products/update/{id}', [ProductController::class, 'update']);
    // Route::delete('/products/delete/{id}', [ProductController::class, 'destroy']);

     Route::get('/products', [ProductController::class,'index']);

    Route::get('/products/create', [ProductController::class,'create']);
    Route::get('/products/edit/{id}', [ProductController::class,'editPage']);

    Route::get('/products/get/{id}', [ProductController::class,'edit']);

    Route::post('/products/store', [ProductController::class,'store']);
    Route::post('/products/update/{id}', [ProductController::class,'update']);

    Route::delete('/products/delete/{id}', [ProductController::class,'destroy']);
    
    // Route::resource('products', \App\Http\Controllers\Vendor\ProductController::class);
});

require __DIR__.'/auth.php';