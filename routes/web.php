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

/*Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@show')->name('dashboard');

//Products shopify
Route::get('/products/shopify', 'ProductsShopify@show')->name('products.shopify');
Route::get('/products/shopify/get-all', 'ProductsShopify@getAll')->name('shopify.getAll');
Route::get('/products/shopify/ajax', 'ProductsShopify@all')->name('products.shopify.ajax');
Route::put('/products/shopify/{id}/update', 'ProductsShopify@updateQuantity')->name('product.shopify.update');
//for testing
Route::get('/products/shopify/{product_id}/{variant_id}/update2', 'ProductsShopify@updateQuantityShopify');

// Settings
Route::get('/settings', 'SettingsController@show')->name('settings.list');
Route::get('/settings/{id}', 'SettingsController@edit')->name('setting');
Route::put('/settings/{id}/update', 'SettingsController@update');

// Audit Trail
Route::get('/audits', 'AuditTrail@show')->name('audits');



// LAZADA OPEN PLATFORM CALLBACK URL
Route::get('/lazada/auth/callback', 'LazadaCallback@callback');