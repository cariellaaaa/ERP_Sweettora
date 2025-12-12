<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\ManufacturingOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
    // return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function(){
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('product-categories', ProductCategoryController::class);
    Route::resource('units', UnitController::class);
    Route::resource('products', ProductController::class);
    Route::resource('bill-of-materials', BillOfMaterialController::class);
    Route::resource('manufacturing-order', ManufacturingOrderController::class);
    Route::get('/ajax/bom-items/{id}', [BillOfMaterialController::class, 'getBomItems']);

});