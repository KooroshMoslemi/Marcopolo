<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResources([
    'user' => 'API\UserController',
    'media' => 'API\MediaController'
]);

Route::GET('/roles','API\UserController@get_roles');
Route::GET('/deactivate/{id}','API\UserController@deactivate');
Route::GET('/control_detail','API\UserController@control_detail');

Route::POST('/add_tag','API\UserController@add_tag');
Route::POST('/add_brand','API\UserController@add_brand');
Route::POST('/add_category','API\UserController@add_category');

Route::GET('/is_used','API\UserController@is_used');
Route::POST('/del_with_mode','API\UserController@del');
Route::POST('/edit_with_mode','API\UserController@edit_with_mode');


Route::POST('/check_media_for_del','API\MediaController@check_media_for_del');
