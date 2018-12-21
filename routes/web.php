<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/overview', 'TestController@test');
Route::get('/remove-products', '2018_11_05_115342_create_products_table@down');

Route::middleware(['auth'])->group(function () {
	Route::get('/groups/{group}/invoices/{date}', 'GroupController@groupTransactions');
	Route::get('/groups/{group}/invite', 'GroupController@groupInvite');
	Route::get('/groups/{group}/transactions', 'GroupController@allTransactions');
	Route::post('/groups/{group_id}/invite/send', 'GroupController@groupInviteSend');
	Route::get('/groups/add/{otp}', 'GroupController@otp');
	Route::get('/transactions/download/{type}/{id}/{date}', 'TransactionController@export');
	Route::resource('products', 'ProductController');
	Route::resource('groups', 'GroupController');
	Route::resource('invoices', 'InvoiceController');
	Route::resource('transactions', 'TransactionController');
});