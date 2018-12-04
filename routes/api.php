<?php

use Illuminate\Http\Request;
use App\RestApi;

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

// custom methods to login by api
Route::middleware('auth:api')
    ->get('/user', function (Request $request) {
        return $request->user();
    });
Route::post('/ddk/register', 'Auth\RegisterController@getAcc');
Route::post('/ddk/login', 'Auth\LoginController@getIn');
Route::post('/ddk/logout', 'Auth\LoginController@getOut');

Auth::guard('api')->user(); // instance of the logged user
Auth::guard('api')->check(); // if a user is authenticated
Auth::guard('api')->id(); // the id of the authenticated user

Route::group(['middleware' => 'auth:api'], function() {
    // rest calls depends on each table built
	Route::get('/ddk/{table}', 'RestApiCont@index');
	Route::get('/ddk/{table}/{id}', 'RestApiCont@show');
	Route::post('/ddk/{table}', 'RestApiCont@store');
	Route::put('/ddk/{table}/{id}', 'RestApiCont@update');
	Route::delete('/ddk/{table}/{id}', 'RestApiCont@delete');
	Route::delete('/ddk/{table}', 'RestApiCont@deleteTable');
});


