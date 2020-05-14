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
Route::get('/','Auth\LoginController@showLoginForm');

Route::get('purchase-login','Auth\PurchaseLoginController@showLoginForm');
Route::post('purchase-login','Auth\PurchaseLoginController@login')->name('purchase-login');

Route::get('gm-login','Auth\GeneralManagerLoginController@showLoginForm');
Route::post('gm-login','Auth\GeneralManagerLoginController@login')->name('gm-login');

Route::get('dm-login','Auth\DepartmentManagerLoginController@showLoginForm');
Route::post('dm-login','Auth\DepartmentManagerLoginController@login')->name('dm-login');

Route::get('tl-login','Auth\TeamLeaderLoginController@showLoginForm');
Route::post('tl-login','Auth\TeamLeaderLoginController@login')->name('tl-login');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');

    
    // Orders
    Route::get('order_form','OrderDetailsController@index');
    Route::post('save_order_list','OrderDetailsController@save_order_list');
    Route::get('get_product_grp/{id}','OrderDetailsController@get_product_grp');
    Route::get('get_item_name/{id}/{id1}','OrderDetailsController@get_item_name');
    Route::get('get_product_type_order_form','OrderDetailsController@get_product_type_order_form');
    Route::get('order_utilize_form','OrderDetailsController@order_utilize_form');
    Route::get('show_order_details_gm/{id}','OrderDetailsController@show_order_details_gm');
    
     
   
    
    
    // Notifcation
    Route::get('nofi_page','OrderDetailsController@nofi_page');
    
    // Purchase
    
    Route::get('purchase_form','OrderDetailsController@purchase_form');
    Route::get('order_list','OrderDetailsController@order_list');
    Route::get('create_purchase_form','OrderDetailsController@create_purchase_form');
    Route::get('create_purchase/{id}/{id1}','OrderDetailsController@create_purchase');
    Route::get('vendor_to_po_dept','OrderDetailsController@vendor_to_po_dept');
    Route::get('update_maker_po_dept/{id}','OrderDetailsController@update_maker_po_dept');
    Route::get('update_checker_po_dept/{id}','OrderDetailsController@update_checker_po_dept');
    Route::get('get_order_utilize_qty_tl/{id}','OrderDetailsController@get_order_utilize_qty_tl');
    Route::post('save_order_utilize','OrderDetailsController@save_order_utilize');
    Route::get('tl_order_utilize_status/{id}','OrderDetailsController@tl_order_utilize_status');
    
    Route::post('save_purchase_order','OrderDetailsController@save_purchase_order');
    
    
    // Order List to DM
    
    Route::get('order_tl_today_dm','OrderDetailsController@order_tl_today_dm');
    Route::get('change_order_status_by_dm/{id}/{id1}/{id2}','OrderDetailsController@change_order_status_by_dm');
    
    // Order List to GM
    Route::get('order_tl_today_gm','OrderDetailsController@order_tl_today_gm');
    Route::get('change_order_status_by_gm/{id}/{id1}/{id2}','OrderDetailsController@change_order_status_by_gm');
    
    
    // order list to TL
    
    Route::get('order_list_to_tl','OrderDetailsController@order_list_to_tl');
    
    // Storage Location
    Route::get('storage_list','OrderDetailsController@add_storage_location');
    Route::get('add_storage_location','OrderDetailsController@add_storage_location');
    Route::post('save_storage','OrderDetailsController@save_storage');
    Route::get('swipe_items_storage/{id}','OrderDetailsController@swipe_items_storage');
    Route::post('update_swipe_data','OrderDetailsController@update_swipe_data');
    
    Route::get('swipe_items_storage1','OrderDetailsController@swipe_items_storage1');
    Route::post('update_swipe_data1','OrderDetailsController@update_swipe_data1');
    
    Route::get('get_rack_slot/{id}','OrderDetailsController@getRackslot');
    Route::get('get_slot','OrderDetailsController@getSlot');
    
    Route::get('show_storage_location_form/{id}','OrderDetailsController@show_storage_location_form');
    Route::get('storage_location','OrderDetailsController@storage_location');
    Route::post('save_storage_location','OrderDetailsController@save_storage_location');
    Route::get('show_storage_location_modal/{id}','OrderDetailsController@show_storage_location_modal');
    Route::post('update_storage_details','OrderDetailsController@update_storage_details');
    
    
    // Items
    
    Route::get('add_item_form','ItemController@add_item_form');
    Route::post('save_item','ItemController@save_item');
    Route::get('item_list','ItemController@item_list');
    Route::get('edit_item_list','ItemController@edit_item_list');
    Route::post('update_item_list/{id}','ItemController@update_item_list');
    
    // Product
    
    Route::get('add_product','ProductController@add_product');
    Route::post('save_product_cate','ProductController@save_product_cate');
    Route::get('product_list','ProductController@product_list');
    Route::get('edit_product_list','ProductController@edit_product_list');
    Route::post('edit_product_cate/{id}','ProductController@edit_product_cate');
    
    
    
    // Vendor
    Route::get('add_vendor','VendorController@add_vendor');
    Route::post('save_vendor','VendorController@save_vendor');
    Route::get('get_item_no_vendor/{id}','VendorController@get_item_no_vendor');
    Route::get('get_item_details_vendor/{id}','VendorController@get_item_details_vendor');
    Route::get('vendor_list','VendorController@vendor_list');
   
    
    
    
    
    
});
