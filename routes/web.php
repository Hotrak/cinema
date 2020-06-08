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
use Spatie\Permission\Models\Role;

Route::get('/', 'FilmController@index')->name('home');
Route::get('films/{id}', 'FilmController@show')->name('film');
Route::post('films', 'FilmController@store');
Route::put('films/{id}', 'FilmController@update');
Route::delete('films/{id}', 'FilmController@destroy');

Route::get('films/schedule/reservation', 'ScheduleController@getReservation');
Route::post('films/schedule/reservation', 'ScheduleController@store');

Route::post('register', 'UserController@store');
Route::post('login', 'UserController@login');
Route::post('logout', 'UserController@destroy');

Route::get('types', 'TypeController@index');

Route::get('comments/{filmId}','CommentController@show');
Route::post('comments','CommentController@store');
Route::delete('comments/{id}','CommentController@delete');
Route::get('/orders/{id}','ReservationController@userOrders');

Route::get('reservation','ReservationController@index');
Route::get('reservation/{id}','ReservationController@show');
Route::delete('reservation/{id}','ReservationController@delete');

Route::post('schedule/','ScheduleController@scheduleAdd');
Route::delete('schedule/{id}','ScheduleController@delete');

Route::get('films/{id}/types','FilmController@filmTypes');




