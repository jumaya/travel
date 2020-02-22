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

/* ROUTES TO CLIENTE FUNCTIONS -----------------------------------------------------*/
Route::get('/', [
    'as' => 'new_client',
    'uses' => 'ClientController@index'
]);

Route::get('/client/new', ['uses'=>'ClientController@create', 'as'=>'client.new']);

Route::get('/client/{id}/edit','ClientController@edit');

Route::post('/client/update','ClientController@update');

Route::resource('client', 'ClientController');

/* -----------------------------------------------------------------------------------*/


/* ROUTES TO TRAVEL FUNCTIONS --------------------------------------------------------*/
Route::get('travel', [
    'as' => 'travel',
    'uses' => 'TravelController@index'
]);

Route::post('/travel/store','TravelController@store');

Route::get('/getTravel','TravelController@getTravel');

Route::post('/travel/delete/{id}','TravelController@delete');

/* -------------------------------------------------------------------------------------*/


/* ROUTES TO RESOUCE POSTMAN FUNCIONES -------------------------------------------------*/
Route::get('/filterClient','ResourceController@getFilterClient');

Route::get('/getClient','ResourceController@getClient');

Route::post('/storeClient','ResourceController@storeClient');

Route::get('/findClientById','ResourceController@findClientById');

Route::get('/findClientByPhone','ResourceController@findClientByPhone');

Route::post('/deleteClient','ResourceController@deleteClient');

Route::post('/xmlTravel','ResourceController@xmlTravel');

Route::get('/getTravelList','ResourceController@getTravelList');

Route::get('/getTravelByClientId','ResourceController@getTravelByClientId');
/* -------------------------------------------------------------------------------------*/

Route::get('/prueba','ResourceController@prueba');