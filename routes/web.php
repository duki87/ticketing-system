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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['role:user']], function () {
    Route::get('/tickets/create', 'TicketController@create')->name('ticket.create');
    Route::post('/tickets/store', 'TicketController@store')->name('ticket.store');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/add-user', 'UserController@add')->name('add-user');
    Route::post('/add-user', 'UserController@create')->name('create-user');
    Route::post('/add-reply/{ticket}', 'ReplyController@store')->name('reply.store');
    Route::put('/update-ticket/{ticket}', 'TicketController@update')->name('ticket.update');
    Route::get('/ticket/statistics', 'TicketController@statistics')->name('ticket.statistics');
});

Route::get('/home/{date?}/{status?}', 'TicketController@index')->name('home');
Route::get('/tickets/{ticket}', 'TicketController@show')->name('ticket.show');