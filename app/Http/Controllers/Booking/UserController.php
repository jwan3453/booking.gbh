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
        $userDetail = $this->userService->getUserDetail();

        $year = [];
        $month = [];
        $day = [];
        for($i=1940; $i < 2018; $i++)
        {
            $year[] = $i;
        }

        for($j=1; $j < 13; $j++)
        {
            $month[] =  $j;
        }

        for($k=1; $k < 32; $k++)
        {
            $day[] =$k;
        }
        $nav = 'profile';

        return view('user.myprofile')->with('userDetail',$userDetail)->with('year',$year)->with('month',$month)->with('day',$day)->with('nav',$nav);

    }

    //保存用户资料
    public function saveProfile(Request $request)
    {
        $result = $this->userService->saveProfile($request);
        if($result)
        {
            return redirect('/user/myprofile');
        }
    }


    public function myOrders()
    {

        $nav = 'order';
        $allOrders =  $this->userService->getAllOrders();
        return view('user.myOrders.all')->with('allOrders',$allOrders)->with('nav',$nav);

    }

    public function unpaidOrders(){
        return view('user.myOrders.unpaid')->with('nav','order');;
    }


    public function uncheckinOrders(){
        return view('user.myOrders.uncheckin')->with('nav','order');;
    }


    public function unconfirmedOrders(){
        return view('user.myOrders.uncheckin')->with('nav','order');;
    }

    public function canceledOrders(){
        return view('user.myOrders.canceled')->with('nav','order');;
    }


    public function orderDetail($orderSn){
        $orderDetail =  $this->orderService->getOrderDetail($orderSn);
        return view('user.myOrders.orderDetail')->with('orderDetail',$orderDetail);
    }




    public function myCollections(){
        $nav = 'collection';
        $collections = $this->userService->getUserCollections();
        return view('user.myCollections')->with('collections',$collections)->with('nav',$nav);

    }

    public function  addToCollection(Request $request)
    {

        $jsonResult = new MessageResult();
        $result = $this->userService->addToCollection($request);
        if($result)
        {
            $jsonResult->statusCode = 1;
        }
        else{
            $jsonResult->statusCode = 0;
        }

        $jsonResult->StatusMsg = '';
        return response($jsonResult->toJson());

    }

    public function removeFromCollection(Request $request)
    {
        $jsonResult = new MessageResult();
        $result = $this->userService->removeFromCollection($request);
        if($result)
        {
            $jsonResult->statusCode = 1;
        }
        else{
            $jsonResult->statusCode = 0;
        }

        $jsonResult->StatusMsg = '';
        return response($jsonResult->toJson());
    }

    public  function myaccount()
    {
        $nav = 'account';
        $jsonResult = new MessageResult();
        $accountDetail = $this->userService->getAccountDetail();
        return view('user.myAccount')->with('accountDetail',$accountDetail)->with('nav',$nav);
    }

}
