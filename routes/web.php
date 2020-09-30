<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::post('LastProduct', 'Admin\ProductController@last_product')->name('LastProduct');

	Route::resource('category', 'Admin\CategoryController');
	Route::resource('company', 'Admin\CompanyController');
	Route::resource('distributor', 'Admin\DistributorController');
	Route::resource('unit', 'Admin\UnitController');
	Route::resource('product', 'Admin\ProductController');
	Route::resource('customer', 'Admin\CustomerController');
	Route::resource('employee', 'Admin\EmployeeController');
	Route::resource('bankentry', 'Admin\BankentryController');
	Route::resource('card', 'Admin\CardController');
	Route::resource('expensetype', 'Admin\ExpensetypeController');
	Route::resource('serviceprovider', 'Admin\ServiceproviderController');
	Route::resource('expense', 'Admin\ExpenseController');
	Route::resource('income', 'Admin\IncomeController');
	Route::resource('barcode', 'Admin\BarcodeController');
	Route::resource('purchasereceipt', 'Admin\PurchasereceiptController');
	Route::resource('purchaselisting', 'Admin\PurchaselistingController');
	


	/***         */
	Route::get('get-purchasereceipt', 'Admin\PurchaselistingController@getPurchasereceipt');
	Route::get('get-product', 'Admin\PurchaselistingController@getProduct');
});

