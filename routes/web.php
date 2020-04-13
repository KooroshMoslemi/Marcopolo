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


use App\Brand;
use App\Category;
use App\Product;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', 'ProductController@welcome')->name('welcome');
Route::get('/panel', 'HomeController@index')->name('home')->middleware('auth','noneuser');//TODO: admin lte will be here also I should create an admin,author,... middleware
Route::post('/clogin',  'AuthController@login');
Route::get('/clogout',  'AuthController@logout');
Route::post('/cregister',  'AuthController@registerUser');
Route::get('/new', 'ProductController@new');
Route::get('/off', 'ProductController@off');
Route::get('product_detail/{id}','ProductController@product_detail');
Route::get('product_detail_with_main_photo/{id}','ProductController@product_detail_with_main_photo');
Route::get('product_detail_media/{id}','ProductController@product_detail_media');
Route::get('/detail/{id}', 'ProductController@showDetail');
//Route::get('/detail/', 'ProductController@showDetail2');
Route::get('/order','ProductController@showOrders')->name('order');
Route::post('/pay','ProductController@pay')->name('pay');
Route::get('/category', 'ProductController@category')->name('category');
Route::get('/category-page-content-detail', 'ProductController@category_page_content_detail');
Route::get('/category-page-search-sidebar-detail', 'ProductController@category_page_search_sidebar_detail');
Route::get('/random-products','ProductController@randomProducts');
Route::get('/popular-products', 'ProductController@popularProducts');
Route::get('/pre-product-edit-details/{id}','ProductController@pre_product_edit_details');
Route::apiResources([
    'product' => 'ProductController',
]);


Route::get('/panel/product_edit/{ProductId}',function($ProductId){
    if(Auth::check() && \Gate::allows('isAdminORDeveloperORSalesPerson')) {
    $categories = Category::all();
    return view('product_edit',compact('ProductId','categories'));
        }
});


//Experimental

Auth::routes();

Route::get('google', function () {
    return view('googleAuth');
});
Route::get('auth/google', 'AuthController@redirectToGoogle');
Route::get('auth/google/callback', 'AuthController@handleGoogleCallback');


Route::get('/panel/{path}','HomeController@index')->where( 'path', '[-A-z0-9_\s]+');
