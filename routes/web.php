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

Route::any('api/getCategoryList',       'ProductController@getCategory');
Route::any('api/getProductByCateId',    'ProductController@getProductsByCateId');
Route::any('api/getProductDtl',         'ProductController@getProductDtl');

Route::any('api/getCartItems',          'CartController@getCartItems');
Route::any('api/deleteCartItem',        'CartController@deleteCartItem');
Route::any('api/updateCartQty',         'CartController@updateCartQty');
