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
Route::get('/schedules', 'ScheduleController@index')->name('schedule','user_id');

Route::post('add-bucket','BucketListController@createBucket');
Route::get('delete-bucket/{id}','BucketListController@removeDestination');


//edit bucket
Route::get('edit-bucket/{id}','BucketListController@bucketData');
Route::post('edit-bucket','BucketListController@editBucket');

Route::post('add-schedule','ScheduleController@createSchedule');

Route::get('edit-schedule/{id}','ScheduleController@editSchedule');
Route::post('update-schedule','ScheduleController@updateSchedule');
Route::get('remove-schedule/{id}','ScheduleController@removeSchedule');
Route::get('color-schedule/{id}','ScheduleController@colorSchedule');

Route::get('/trips','TripsController@index')->name('trips');
Route::get('/edit-trips/{id}','TripsController@editTrip');
Route::post('edit-story','TripsController@createStory');
