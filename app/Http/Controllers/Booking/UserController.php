<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\MessageResult;
use App\Service\Order\OrderService;
use App\Service\User\UserService;
use App;

class UserController extends Controller
{

    private $orderService;
    private $userService;

    public function __construct(OrderService $orderService,UserService $userService){

        $this->orderService = $orderService;
        $this->userService = $userService;
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


    //新订单
    public function myProfile()
    {

        return view('user.myprofile');

    }


    public function myOrders()
    {

        $allOrders =  $this->userService->getAllOrders();
        return view('user.myOrders.all')->with('allOrders',$allOrders);

    }

    public function unpaidOrders(){
        return view('user.myOrders.unpaid');
    }


    public function uncheckinOrders(){
        return view('user.myOrders.uncheckin');
    }


    public function unconfirmedOrders(){
        return view('user.myOrders.uncheckin');
    }

    public function canceledOrders(){
        return view('user.myOrders.canceled');
    }

    public function myCollections(){

    }


    public function orderDetail($orderSn){

        $orderDetail =  $this->orderService->getOrderDetail($orderSn);

        return view('user.myOrders.orderDetail')->with('orderDetail',$orderDetail);
    }

}
