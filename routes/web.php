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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'TicketController@index')->name('home');
Route::get('/tickets/{ticket}', 'TicketController@show')->name('ticket.show');

//User
Route::get('/create-ticket', 'TicketController@create')->name('ticket.create');
Route::post('/create-ticket', 'TicketController@store')->name('ticket.store');

//Admin
Route::get('/add-user', 'UserController@add')->name('add-user');
Route::post('/add-user', 'UserController@create')->name('create-user');
Route::post('/add-reply/{ticket}', 'ReplyController@store')->name('reply.store');
Route::get('/close-ticket/{ticket}', 'TicketController@close')->name('ticket.close');
//Route::get('/ticket/{id}', 'TicketController@edit')->name('edit-ticket');
//Route::get('/ticket/close/{id}', 'TicketController@close_ticket')->name('close-ticket');
