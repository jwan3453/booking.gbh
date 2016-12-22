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


//搜索
Route::get('/search/{keyword}','Booking\BookingController@search');



//获取所有目的地
Route::post('/getDestinationCitiesHotels','Booking\BookingController@getDestinationCitiesHotels');


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


//更具时间搜索房间
Route::post('/searchRoomByDate','Booking\BookingController@searchRoomByDate');


//根据时间所搜索新房价
Route::post('/searchPriceByDate','Booking\OrderController@searchPriceByDate');

//新订单
Route::get('/newOrder/{hotelId}/{roomId}/{checkInDate}/{checkOutDate}','Booking\OrderController@newOrder');



//登录
Route::get('/login','Auth\LoginController@index');
Route::post('/login','Auth\LoginController@index');
Route::get('/auth/login','Auth\LoginController@index');
//退出登录,清楚缓存
Route::get('/logout','Auth\LoginController@logout');
//注册
Route::get('/register','Auth\LoginController@register');
Route::any('/auth/register','Auth\LoginController@register');
Route::post('/sendCode','Auth\LoginController@sendCode');
Route::post('/checkUser','Auth\LoginController@checkUser');
Route::post('/checkEmail','Auth\LoginController@checkEmail');

//验证手机号
Route::any('/checkMobile','Auth\LoginController@checkMobile');
//验证码
Route::post('/checkCode','Auth\LoginController@checkCode');
//注册成功
Route::any('/regSuccess','Auth\LoginController@regSuccess');
Route::any('/userSession','Auth\LoginController@userSession');
//发送邮箱
Route::post('/auth/sendMessage','Auth\LoginController@sendMessage');
//修改密码
Route::any('/jumpAddress/{key}','Auth\LoginController@jumpAddress');
Route::any('/changePasswordByMobile','Auth\LoginController@passwordByMobile');
Route::post('/searchMobile','Auth\LoginController@searchMobile');
Route::any('/changePasswordByEmail','Auth\LoginController@changePassword');

