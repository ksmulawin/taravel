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
Route::get('/bucket_list', 'BucketListController@index')->name('bucket'); // url name,controller@function, route name

Route::post('add-bucket','BucketListController@createBucket');
Route::get('delete-bucket/{id}','BucketListController@removeDestination');


//edit bucket
Route::get('edit-bucket/{id}','BucketListController@bucketData');
Route::post('edit-bucket','BucketListController@editBucket');
