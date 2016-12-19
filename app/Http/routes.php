<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', function () {
    return view('welcome');
});

//just an API testing calls
Route::post('wp_post', 'PurchaseOrderController@wp_post');
Route::any('/show_product', function(){
	$product = \DB::table('products')->get();
	return json_encode($product);
});
//ENDjust an API testing calls

Route::auth();

Route::get('/home', 'HomeController@index');

Route::post('deleteCategory', 'CategoryController@destroy');
Route::resource('category', 'CategoryController');

//Product
Route::post('deleteProduct', 'ProductController@destroy');
Route::resource('product', 'ProductController');

//Suppliers
Route::post('deleteSupplier', 'SupplierController@destroy');
Route::resource('supplier', 'SupplierController');

//Unit
Route::post('deleteUnit', 'UnitController@destroy');
Route::resource('unit', 'UnitController');


//Customer
Route::post('deleteCustomer', 'CustomerController@destroy');
Route::resource('customer', 'CustomerController');

//Purchase orders
	
	//complete purchase order
	Route::post('completePurchaseOrder', 'PurchaseOrderController@complete');
	//accept purchase order
	Route::post('acceptPurchaseOrder', 'PurchaseOrderController@accept');
	//delete
	Route::post('deletePurchaseOrder', 'PurchaseOrderController@destroy');
	//Print
	Route::get('purchase-order/{id}/printPdf', 'PurchaseOrderController@printPdf');
	//Save Purchase Order
	Route::post('storePurchaseOrder', 'PurchaseOrderController@store');
	//Update
	Route::put('UpdatePurchaseOrder', 'PurchaseOrderController@update');
	Route::resource('purchase-order', 'PurchaseOrderController');

//Purchase Order Invoice
	Route::post('payPurchaseOrderInvoice', 'PurchaseOrderInvoiceController@payInvoice');
	Route::get('purchase-order-invoice/{purchase_order_id}/create', 'PurchaseOrderInvoiceController@create');
	Route::post('storePurchaseOrderInvoice', 'PurchaseOrderInvoiceController@store');
	Route::post('deletePurchaseOrderInvoice', 'PurchaseOrderInvoiceController@destroy');
	Route::put('updatePurchaseOrderInvoice', 'PurchaseOrderInvoiceController@update');
	Route::resource('purchase-order-invoice', 'PurchaseOrderInvoiceController');

//Purchase Return
	//complete purchase return
	Route::post('completePurchaseReturn', 'PurchaseReturnController@changeToCompleted');
	//Send purchase return
	Route::post('sendPurchaseReturn', 'PurchaseReturnController@changeToSent');
	//Save Purchase Return
	Route::post('storePurchaseReturn', 'PurchaseReturnController@store');
	Route::resource('purchase-return', 'PurchaseReturnController');


//Sales Order Controller
	Route::resource('sales-order', 'SalesOrderController');

Route::controller('datatables', 'DatatablesController',[
	'getProducts'=>'datatables.getProducts',
	'getSuppliers'=>'datatables.getSuppliers',
	'getUnits'=>'datatables.getUnits',
	'getPurchaseOrders'=>'datatables.getPurchaseOrders',
	'getPurchaseOrderInvoices'=>'datatables.getPurchaseOrderInvoices',
	'getPurchaseReturns'=>'datatables.getPurchaseReturns',
	'getCustomers'=>'datatables.getCustomers',
	
]);