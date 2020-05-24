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

//Auth::routes();

Auth::routes([
    'register' => false
]);

Route::get('/register', function() {
    return redirect()->back();
});

Route::group(['middleware' => ['role:user']], function () {
    Route::get('/tickets/create', 'TicketController@create')->name('ticket.create');
    Route::post('/tickets/store', 'TicketController@store')->name('ticket.store');
    Route::get('/users/edit', 'UserController@edit')->name('user.edit');
    Route::put('/users/update', 'UserController@update')->name('user.update');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/users/create', 'UserController@create')->name('user.create');
    Route::post('/users/store', 'UserController@store')->name('user.store'); 
    Route::get('/tickets-statistics', 'TicketController@statistics')->name('ticket.statistics');
});

Route::get('/home', 'TicketController@index')->name('home');
Route::get('/tickets/load', 'TicketController@load')->name('ticket.load');
Route::get('/tickets/{ticket}/close', 'TicketController@close')->name('ticket.close');
Route::get('/tickets/{ticket}', 'TicketController@show')->name('ticket.show');
Route::post('/add-reply/{ticket}', 'ReplyController@store')->name('reply.store');