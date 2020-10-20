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
    return redirect('/login');
});

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');*/

// Dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'App\Http\Controllers\DashboardController@show')->name('dashboard');

//Products shopify
Route::middleware(['auth:sanctum', 'verified'])->get('/products/shopify', 'App\Http\Controllers\ProductsShopify@show')->name('products.shopify');
Route::middleware(['auth:sanctum', 'verified'])->get('/products/shopify/get-all', 'App\Http\Controllers\ProductsShopify@getAll')->name('shopify.getAll');
Route::middleware(['auth:sanctum', 'verified'])->get('/products/shopify/ajax', 'App\Http\Controllers\ProductsShopify@all')->name('products.shopify.ajax');
Route::put('/products/shopify/{id}/update', 'App\Http\Controllers\ProductsShopify@updateQuantity')->name('product.shopify.update');
//for testing
Route::get('/products/shopify/{product_id}/{variant_id}/update2', 'App\Http\Controllers\ProductsShopify@updateQuantityShopify');

// Settings
Route::middleware(['auth:sanctum', 'verified'])->get('/settings', 'App\Http\Controllers\SettingsController@show')->name('settings.list');
Route::middleware(['auth:sanctum', 'verified'])->get('/settings/{id}', 'App\Http\Controllers\SettingsController@edit')->name('setting');
Route::put('/settings/{id}/update', 'App\Http\Controllers\SettingsController@update');


