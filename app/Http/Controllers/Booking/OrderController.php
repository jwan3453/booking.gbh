<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\User\UserService;
use App\Tool\MessageResult;

use App;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(UserService $orderService){

        $this->orderService = $orderService;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //生成新订单
    public function newOrder($hotelId, $roomId, $checkInDate, $checkOutDate)
    {

        $hotelRoomDetail = $this->orderService->getRoomDetail($hotelId, $roomId, $checkInDate, $checkOutDate);
        return view('order.newOrder')->with('hotelRoomDetail',$hotelRoomDetail);
    }

    //根据时间所搜索新房价
    public function searchPriceByDate(Request $request){

        dd('asdasd');
        $hotelId = $request->input('hotel');
        $roomId = $request->input('roomId');
        $checkInDate = $request->input('checkInDate');
        $checkOutDate = $request->input('checkOutDate');
        $numOfRoom = $request->input('numOfRoom');

        $jsonResult = new MessageResult();
        $searchResult = $this->orderService->searchPriceByDate($hotelId,$roomId,$checkInDate,$checkOutDate,$numOfRoom);
        $jsonResult->statusCode =1;
        $jsonResult->StatusMsg = '';
        $jsonResult->extra = $searchResult;
        return response($jsonResult->toJson());

    }


}
