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

//Purchase orders
//Save Purchase Order
Route::post('storePurchaseOrder', 'PurchaseOrderController@store');
Route::resource('purchase-order', 'PurchaseOrderController');

Route::controller('datatables', 'DatatablesController',[
	'getProducts'=>'datatables.getProducts',
	'getSuppliers'=>'datatables.getSuppliers',
	'getPurchaseOrders'=>'datatables.getPurchaseOrders',
]);