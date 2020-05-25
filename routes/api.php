<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:api'], function() { 
    Route::apiResources([   
        'tickets'    => 'API\TicketController',
    ]);
    Route::get('tickets/{tck_no}/{user}/status', 'API\TicketController@check_ticket_status')->name('api.ticket.status');
});
