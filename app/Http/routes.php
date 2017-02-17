<?php


Route::get('/', function () {
    return view('welcome');
});

//API testing calls
Route::post('wp_post', 'PurchaseOrderController@wp_post');
Route::any('/show_product', function(){
	$product = \DB::table('products')->get();
	return json_encode($product);
});
//ENDjust an API testing calls

Route::auth();

Route::get('/home', 'HomeController@index');

//Bank
Route::post('deleteBank', 'BankController@destroy');
Route::resource('bank', 'BankController');

//Category
Route::post('deleteCategory', 'CategoryController@destroy');
Route::resource('category', 'CategoryController');

//Stock Balance
//Update
Route::put('UpdateSalesOrder', 'SalesOrderController@update');
Route::post('deleteStockBalance','StockBalanceController@destroy');
Route::resource('stock_balance','StockBalanceController');

//Driver
Route::get('/func',function(){
    return Helper::uc_words("imsak haqiqy");
});
Route::post('deleteDriver', 'DriverController@destroy');
Route::resource('driver','DriverController');

//Product
Route::post('check_product_availability', 'ProductController@check_product_availability');
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
	Route::resource('purchase-order', 'PurchaseOrderController'); //

//Purchase Order Invoice
	Route::post('storePurchasePaymentTransfer', 'PurchaseOrderInvoiceController@storePaymentTransfer');
	Route::post('storePurchasePaymentCash', 'PurchaseOrderInvoiceController@storePaymentCash');
	Route::post('completePurchaseInvoice', 'PurchaseOrderInvoiceController@completePurchaseInvoice');
	Route::get('purchase-order-invoice/{invoice_id}/payment/create', 'PurchaseOrderInvoiceController@createPayment');
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


//Sales Order
	//Save
	Route::post('storeSalesOrder', 'SalesOrderController@store');
	//Update sales order status
	Route::post('sales-order/updateStatus', 'SalesOrderController@updateStatus');
	//Update
	Route::put('UpdateSalesOrder', 'SalesOrderController@update');
	//delete
	Route::post('deleteSalesOrder', 'SalesOrderController@destroy');
	Route::resource('sales-order', 'SalesOrderController');

//Sales order invoice
	Route::post('completeSalesInvoice', 'SalesOrderInvoiceController@completeSalesInvoice');
	Route::post('deleteSalesOrderInvoice', 'SalesOrderInvoiceController@destroy');
	Route::post('storeSalesOrderInvoice', 'SalesOrderInvoiceController@store');
	Route::get('sales-order-invoice/{sales_order_id}/create', 'SalesOrderInvoiceController@create');
	Route::get('sales-order-invoice/{invoice_id}/payment/create', 'SalesOrderInvoiceController@createPayment');
	Route::post('storeInvoicePayment', 'SalesOrderInvoiceController@storeInvoicePayment');
	Route::resource('sales-order-invoice', 'SalesOrderInvoiceController');

//Invoiceterms
	Route::resource('invoice-term', 'InvoiceTermController');


Route::controller('datatables', 'DatatablesController',[
	'getProducts'=>'datatables.getProducts',
	'getSuppliers'=>'datatables.getSuppliers',
	'getUnits'=>'datatables.getUnits',
	'getPurchaseOrders'=>'datatables.getPurchaseOrders',
	'getPurchaseOrderInvoices'=>'datatables.getPurchaseOrderInvoices',
	'getSalesOrders'=>'datatables.getSalesOrders',
	'getSalesOrderInvoices'=>'datatables.getSalesOrderInvoices',
	'getPurchaseReturns'=>'datatables.getPurchaseReturns',
	'getCustomers'=>'datatables.getCustomers',
	'getInvoiceTerms'=>'datatables.getInvoiceTerms',
    'getDrivers'=>'datatables.getDrivers',

    'getStockBalances' => 'datatables.getStockBalances',

    'getBanks'=>'datatables.getBanks',

]);
