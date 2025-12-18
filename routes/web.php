<?php

use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ManufacturingOrderController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', ProductController::class);
    Route::resource('bill-of-materials', BillOfMaterialController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('purchase-orders', PurchaseController::class);
    Route::resource('inventories', InventoryController::class);
});
