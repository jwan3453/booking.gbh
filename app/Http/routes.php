<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



//酒店预订首页
Route::get('/','Booking\BookingController@home');


//获取所有目的地
Route::post('/getDestinationCities','Booking\BookingController@getDestinationCities');



//酒店详情页
Route::get('/hotel/{hotelId}','Booking\BookingController@hotelDetail');



//酒店系列
Route::get('/category/{category}','Booking\BookingController@hotelCategory');

//目的地
Route::get('/destinationList','Booking\BookingController@destinationList');

//目的地酒店
Route::get('/hotelByCity/{area}/{cityCode}','Booking\BookingController@hotelByCity');


//更换语言
Route::get('/lang/{lang}','Common\CommonController@setLang');



Route::get('/testDestination','Booking\BookingController@testDest');
