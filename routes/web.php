<?php

use \App\Http\Controllers\InventoriesController;
use \App\Http\Controllers\StockAdjustmentsController;
use \App\Http\Controllers\WarehousesController;
// use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\BillOfMaterialController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManufacturingOrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReceiveItemsController;
use App\Http\Controllers\UnitController;
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
    Route::resource('manufacturing-order', ManufacturingOrderController::class);
    Route::get('/ajax/bom-items/{id}', [BillOfMaterialController::class, 'getBomItems']);
    Route::resource('vendors', VendorController::class);
    Route::resource('purchase-orders', PurchaseController::class);
    Route::resource('receive-items', ReceiveItemsController::class);

    Route::resource('warehouses', WarehousesController::class);
    Route::get('/api/cities/{provinceId}', [WarehousesController::class, 'getCities'])->name('api.cities');
    Route::resource('inventories', InventoriesController::class);
    Route::resource('stock-adjustments', StockAdjustmentsController::class);
    
    Route::resource('employees', EmployeeController::class);
});
