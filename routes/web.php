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
Route::get('/feevent/{id}', ['uses' =>'frontendController@index','as'=>'feevent.index']);

Route::get('/logout', ['uses' =>'dashboardController@logout','as'=>'dashboardController.logout']);
Route::get('/', ['uses' =>'loginController@index','as'=>'landingLogin.index']);

/** Route For Login */
    Route::get('/twitter-login', ['uses' =>'loginController@twitterLogin','as'=>'twitter.login']);
    Route::get('/twitter-callback', ['uses' =>'loginController@twitterCallback','as'=>'twitter.loginCallback']);

Route::group(['middleware' => 'seller_auth'], function() {
/** Route For Admin */
Route::group(['namespace' => 'Admin','prefix' => 'admin'], function () {
    // Landing Page Dashboard
    Route::get('/', ['uses' =>'dashboardController@index','as'=>'dashboardController.index']);
    Route::get('/logout', ['uses' =>'dashboardController@logout','as'=>'dashboardController.logout']);
   
    //location 
    Route::get('/location', ['uses' =>'locationController@index','as'=>'location.index']);
    Route::post('/location-save', ['uses' =>'locationController@save','as'=>'location.save']);
    Route::get('/location-ajax', ['uses' =>'locationController@indexAjax','as'=>'location.indexAjax']);
    Route::get('/location-edit', ['uses' =>'locationController@edit','as'=>'location.edit']);
    Route::get('/location-delete/{id}', ['uses'=>'locationController@delete','as'=>'location.delete']);

      //event 
      Route::get('/event', ['uses' =>'eventController@index','as'=>'event.index']);
      Route::post('/event-save', ['uses' =>'eventController@save','as'=>'event.save']);
      Route::get('/event-ajax', ['uses' =>'eventController@indexAjax','as'=>'event.indexAjax']);
      Route::get('/event-edit', ['uses' =>'eventController@edit','as'=>'event.edit']);
      Route::get('/event-delete/{id}', ['uses'=>'eventController@delete','as'=>'event.delete']);

        //Ticket 
        Route::get('/ticket', ['uses' =>'ticketController@index','as'=>'ticket.index']);
        Route::post('/ticket-save', ['uses' =>'ticketController@save','as'=>'ticket.save']);
        Route::get('/ticket-ajax', ['uses' =>'ticketController@indexAjax','as'=>'ticket.indexAjax']);
        Route::get('/ticket-edit', ['uses' =>'ticketController@edit','as'=>'ticket.edit']);
        Route::get('/ticket-delete/{id}', ['uses'=>'ticketController@delete','as'=>'ticket.delete']);
  

        //Transaction 
        Route::get('/transaction', ['uses' =>'transactionController@index','as'=>'transaction.index']);
        Route::get('/transaction-ajax', ['uses' =>'transactionController@indexAjax','as'=>'transaction.indexAjax']);
        Route::get('/transaction-edit', ['uses' =>'transactionController@edit','as'=>'transaction.edit']);
        //My Event
        Route::get('/myevent', ['uses' =>'myEventController@index','as'=>'myevent.index']);
        Route::get('/myevent-ajax', ['uses' =>'myEventController@indexAjax','as'=>'myevent.indexAjax']);
        Route::get('/myevent-edit', ['uses' =>'myEventController@edit','as'=>'myevent.edit']);
    });
});
