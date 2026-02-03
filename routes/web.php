<?php

use App\Http\Controllers\ArtisanGroupController;
use App\Models\Purchase;
use App\Models\ProductType;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaharController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DesignInfoController;
use App\Http\Controllers\MasterInfoController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\WorkerInfoController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\OrderReceiveController;
use App\Http\Controllers\MaterialSetupController;
use App\Http\Controllers\StoreCategoryController;
use App\Http\Controllers\ProcessSectionController;
use App\Notifications\StoreRequsitionNotification;
use App\Http\Controllers\MaterialReceiveController;
use App\Http\Controllers\OrderProcessingController;
use App\Http\Controllers\OtherOrderSheetController;
use App\Http\Controllers\PurchaseReceiveController;
use App\Http\Controllers\SampleWorkOrderController;
use App\Http\Controllers\StoreRequsitionController;
use App\Http\Controllers\ConsumptionSetupController;
use App\Http\Controllers\EmbOrderSheetController;
use App\Http\Controllers\EmbroideryOrderController;
use App\Http\Controllers\OrderDistributionController;
use App\Http\Controllers\PurchaseRequsitionController;
use App\Http\Controllers\ProductionWorkOrderController;
use App\Http\Controllers\OtherOrderSheetTotalController;
use App\Http\Controllers\ProductionChallanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginPost'])->name('loginPost');
Route::get('/dashboard', function () {
    return view('layouts.app');
});
Route::get('/users', function(){
    return view('users.index');
});
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

// Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
// Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
// Route::get('/permission/{id}', [PermissionController::class, 'show']);
// Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
// Route::put('/permission/{permission}/update', [PermissionController::class, 'update'])->name('permission.update');
// Route::delete('/permission/{permission}/delete', [PermissionController::class, 'destroy'])->name('permission.delete');

Route::group(['middleware' => 'role:super-admin|admin'],function() {

Route::resource('/permission', PermissionController::class);
Route::resource('/role', RoleController::class);
Route::get('/give-permission/{role}/add', [RoleController::class, 'addPermission'])->name('permission.give-permission');
Route::put('/give-permission/{role}/update', [RoleController::class, 'givePermission'])->name('permission.give-permission.update');
Route::resource('/users', UserController::class);

});

// Store Setting Routing Start

Route::group(['middleware' => 'role:Store Staff|manager|admin'], function(){

Route::resource('/store', StoreController::class);
Route::resource('/store-category', StoreCategoryController::class);
Route::resource('/material-setup', MaterialSetupController::class);
Route::get('/get-store-category',[MaterialSetupController::class, 'getStoreCategory'])->name('get-store-cat');
//Route::post('/fetch-store-category',[MaterialSetupController::class, 'getStoreCategory']);
Route::resource('/unit', UnitController::class);
Route::resource('/supplier', SupplierController::class);
// Route::resource('/material-receive', MaterialReceiveController::class);
Route::resource('/purchase-receive', PurchaseReceiveController::class);
Route::post('/purchase-receive', [PurchaseReceiveController::class,'store'])->name('purchase-store');
Route::post('/purchase-receive/{id}/approve', [PurchaseReceiveController::class,'purchaseApprove'])->name('purchase-receive.approve');
Route::get('/get-material', [PurchaseReceiveController::class,'getMaterialData']);

Route::resource('/section', SectionController::class);

// Store Requsition Route Start

Route::resource('/store-requsition', StoreRequsitionController::class);
Route::post('/store-requsition/{id}/approve', [StoreRequsitionController::class,'storeRequsitionApprove'])->name('store-requsition.approve');
Route::post('/store-requsition/{id}/recommended', [StoreRequsitionController::class,'recommend'])->name('store-requsition.recommended');
Route::get('/get-material-requsition', [StoreRequsitionController::class, 'getMaterialDataStoreRequsition']);
Route::get('/markasread/{id}', [StoreRequsitionController::class, 'markasread'])->name('markasread');

Route::get('/notifications/count', [StoreRequsitionController::class, 'count'])->name('notifications.count');

Route::get('/notifications/list', [StoreRequsitionController::class, 'nshow'])->name('notifications.list');
// Route::get('/notifications/list', [OtherOrderSheetController::class, 'nshow'])->name('notifications.listOther');


// Route::get('/notify', [StoreRequsitionController::class, 'notification']);

// Store Requsition Route End

// Purchase Requsition Routing Start
Route::resource('/purchase-requsition', PurchaseRequsitionController::class);
Route::post('/purchase-requsition/{id}/approve', [PurchaseRequsitionController::class,'purchaseRequsitionApprove'])->name('purchase-requsition.approve');
Route::post('/purchase-requsition/{id}/recommended', [PurchaseRequsitionController::class,'recommend'])->name('purchase-requsition.recommended');
Route::get('/get-material-requsition', [PurchaseRequsitionController::class, 'getMaterialDataPurchaseRequsition']);

// Purchase Requsition Routing End
Route::resource('/master-info', MasterInfoController::class);

// Consumption Item Routing Start
Route::resource('/item', ItemController::class);
Route::resource('/bahar', BaharController::class);
Route::resource('/size', SizeController::class);
Route::resource('/consumption-setup', ConsumptionSetupController::class);
Route::get('/get-material-consumption', [ConsumptionSetupController::class,'getMaterialDataConsumption']);
Route::get('/get-size-consumption', [ConsumptionSetupController::class,'getSizeConsumption']);
// Consumption Item Routing End

// Smaple Work Order Routing Start

Route::resource('/sample-work-order', SampleWorkOrderController::class);
Route::post('/sample-work-order/{id}/approve', [SampleWorkOrderController::class,'sampleOrderApprove'])->name('sample-work-order.approve');
Route::post('/sample-work-order/{id}/recommended', [SampleWorkOrderController::class,'recommend'])->name('sample-work-order.recommended');
Route::get('/get-materials/{item_id}', [SampleWorkOrderController::class, 'getMaterials']);
Route::get('/get-bahars/{material_id}', [SampleWorkOrderController::class, 'getBahars']);
Route::get('/get-sizes/{bahar_id}/{material_setup_id}', [SampleWorkOrderController::class, 'getSizes']);
Route::get('/get-consumption-qty', [SampleWorkOrderController::class, 'getConsumptionQty']);
Route::get('/get-unit', [SampleWorkOrderController::class, 'getUnitIdUnitName']);

Route::resource('/production-work-order', ProductionWorkOrderController::class);
Route::post('/production-work-order/{id}/approve', [ProductionWorkOrderController::class,'productionOrderApprove'])->name('production-work-order.approve');
Route::post('/production-work-order/{id}/recommended', [ProductionWorkOrderController::class,'recommend'])->name('production-work-order.recommended');


Route::resource('/worker-info', WorkerInfoController::class);

// Smaple Work Order Routing End

//Order Processing Routing Start

Route::resource('/order-processing', OrderProcessingController::class);
Route::get('/order-processing/{id}/new', [OrderProcessingController::class, 'orderShow'])->name('orderno');
Route::post('/order-processing/{id}', [OrderProcessingController::class, 'orderStoreOrUpdate'])
     ->name('order.processing.store.update');

Route::resource('/process-section', ProcessSectionController::class);

// Route::get('/get-work-order-no', [OrderDistributionController::class,'getWorkOrderNo']);

//Order Processing Routing End

//Order Distribution Routing Start

Route::resource('/order-distribution', OrderDistributionController::class);
Route::get('/order-distribution-check/{id}', [OrderDistributionController::class, 'productionEdit'])->name('orderpro');
// Route::post('/order-distribution-check/{id}', [OrderDistributionController::class, 'stores'])->name('newsave');

Route::post('/order-distribution/store', [OrderDistributionController::class, 'stores'])
    ->name('order-distribution.newstore');

Route::get('/order-dist/{id}', [OrderDistributionController::class,'orderShow'])->name('order-dist.orderShow');
Route::get('/order-dist/{id}/create', [OrderDistributionController::class,'receive'])->name('order-dist.receive');

// Route::get('/get-work-order-no', [OrderDistributionController::class,'getWorkOrderNo']);

//Order Distribution Routing End

//Order Receive Routing Start
Route::resource('/order-receive', OrderReceiveController::class);

//Order Receive Routing End

//Others Order Sheet Routing Start
Route::resource('/other-order-sheet', OtherOrderSheetController::class);
Route::post('/other-order-sheet/{id}/recommended', [OtherOrderSheetController::class,'recommend'])->name('other-order-sheet.recommended');
Route::post('/other-order-sheet/{id}/approve', [OtherOrderSheetController::class,'otherOrderApprove'])->name('other-order-sheet.approve');
//Others Order Sheet Routing End

//Others Order Sheet Routing Start
Route::resource('/other-order-sheet-total', OtherOrderSheetTotalController::class);
Route::post('/other-order-sheet-total/{id}/recommended', [OtherOrderSheetTotalController::class,'recommend'])->name('other-order-sheet-total.recommended');
Route::post('/other-order-sheet-total/{id}/approve', [OtherOrderSheetTotalController::class,'otherOrderApprove'])->name('other-order-sheet-total.approve');
//Others Order Sheet Routing End

// Product Setup Routing Start

Route::resource('/product-type', ProductTypeController::class);

Route::get('/fabric-stock', [StockController::class,'fabric'])->name('fabric.stock');
Route::get('/accessories-stock', [StockController::class,'accessories'])->name('accessories.stock');

//Design Routing Start
Route::resource('design-info', DesignInfoController::class);
Route::resource('production-challan', ProductionChallanController::class);
Route::get('/get-work-order/{id}', [ProductionChallanController::class, 'getWorkOrder']);
Route::post('/production-challan/{id}/recommended', [ProductionChallanController::class,'recommend'])->name('production-challan.recommended');
Route::post('/production-challan/{id}/approve', [ProductionChallanController::class,'productionChallanApprove'])->name('production-challan.approve');

//Design Routing End

// Product Setup Routing End

Route::resource('artisan-group', ArtisanGroupController::class);
Route::resource('emb-order-sheet', EmbroideryOrderController::class);


Route::get(
    'get-production-challan-details/{id}',
    [EmbroideryOrderController::class, 'getChallanDetails']
)->name('get.challan.details');

Route::post('/emb-order-sheet/{id}/recommended', [EmbroideryOrderController::class,'recommend'])->name('emb-order-sheet.recommended');
Route::post('/emb-order-sheet/{id}/approve', [EmbroideryOrderController::class,'embroideryOrderApprove'])->name('emb-order-sheet.approve');



});







// Route::get('/login');
