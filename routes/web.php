<?php
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\DashboardController;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::fallback(function () {
     return view('errors.404');
});

Route::get('/login', function () {
    return redirect()->route('login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::get('/edit', [HomeController::class, 'EditProfile'])->name('EditProfile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('edit');
    Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');
    Route::post('/password-update/{Id?}', [UserController::class, 'passwordupdate'])->name('passwordupdate');
    Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');
    Route::get('export/', [UserController::class, 'export'])->name('export');
});



Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{slug}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{slug}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{slug}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulkDelete');
    Route::post('categories/change-status', [CategoryController::class, 'changeStatus'])->name('categories.changeStatus');
});


Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('categories/{category_id}/subcategories', [SubcategoryController::class, 'manageByCategory'])
        ->name('categories.subcategories');

    Route::post('categories/{category_id}/subcategories/store', [SubcategoryController::class, 'storeByCategory'])
        ->name('categories.subcategories.store');

    Route::get('categories/{category_id}/subcategories/{id}/edit', [SubcategoryController::class, 'editByCategory'])
        ->name('categories.subcategories.edit');

    Route::put('categories/{category_id}/subcategories/{id}/update', [SubcategoryController::class, 'updateByCategory'])
        ->name('categories.subcategories.update');

    Route::delete('categories/{category_id}/subcategories/{id}/delete', [SubcategoryController::class, 'deleteByCategory'])
        ->name('categories.subcategories.delete');

    Route::post('categories/{category_id}/subcategories/bulk-delete', [SubcategoryController::class, 'bulkDeleteByCategory'])
        ->name('categories.subcategories.bulkDelete');


    Route::get('products/{product_id}/images', [ProductImageController::class, 'manageByProduct'])
        ->name('products.images');

    Route::post('products/{product_id}/images/store', [ProductImageController::class, 'storeByProduct'])
        ->name('products.images.store');

    Route::get('products/{product_id}/images/{id}/edit', [ProductImageController::class, 'editByProduct'])
        ->name('products.images.edit');

    Route::put('products/{product_id}/images/{id}/update', [ProductImageController::class, 'updateByProduct'])
        ->name('products.images.update');

    Route::delete('products/{product_id}/images/{id}/delete', [ProductImageController::class, 'deleteByProduct'])
        ->name('products.images.delete');

    Route::post('products/{product_id}/images/bulk-delete', [ProductImageController::class, 'bulkDeleteByProduct'])
        ->name('products.images.bulkDelete');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('products-bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::post('products-status/{slug}', [ProductController::class, 'changeStatus'])->name('products.changeStatus');
    Route::get('get-subcategories/{category_id}', [ProductController::class, 'getSubcategories'])->name('products.getSubcategories');
    Route::delete('product-image/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('inquiries', InquiryController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::post('inquiries-bulk-delete', [InquiryController::class, 'bulkDelete'])->name('inquiries.bulkDelete');
});