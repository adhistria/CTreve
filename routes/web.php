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
Route::post("/login",'UserController@authenticate');
Route::get("/user",'UserController@getAuthenticatedUser');
Route::group(['middleware'=> 'jwt.auth'],function (){
    Route::put("/user",'UserController@update');
    Route::post("/user/point",'UserController@addUserPoint');
    Route::post("/transaction",'TransactionController@store');
    Route::get("/transaction",'TransactionController@index');
    Route::get("/user/point",'UserController@getUserPoint');
    
});
