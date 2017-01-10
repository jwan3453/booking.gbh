<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tool\MessageResult;

use App\Service\Order\OrderService;

class OrderController extends Controller
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //新订单
    public function newOrder($hotelId, $roomId, $checkInDate, $checkOutDate)
    {

        $offerDetail = $this->orderService->getRoomDetail($hotelId, $roomId, $checkInDate, $checkOutDate);
        return view('order.newOrder')->with('offerDetail', $offerDetail);
    }


    //创建新订单
    public function createOrder(Request $request)
    {
        $order = $this->orderService->createOrder($request);

        if ($order != null) {
            //重定向到支付页面
            return redirect('/payment/pay/' . $order->order_sn);
        }
    }


    //根据时间所搜索新房价
    public function searchPriceByDate(Request $request)
    {


        $hotelId = $request->input('hotel');
        $roomId = $request->input('room');
        $checkInDate = $request->input('checkInDate');
        $checkOutDate = $request->input('checkOutDate');
        $numOfRoom = $request->input('numOfRoom');


        $jsonResult = new MessageResult();
        $searchResult = $this->orderService->searchPriceByDate($hotelId, $roomId, $checkInDate, $checkOutDate, $numOfRoom);
        $jsonResult->statusCode = 1;
        $jsonResult->StatusMsg = '';
        $jsonResult->extra = $searchResult;

        return response($jsonResult->toJson());

    }


    //支付订单
    public function payOrder($orderSn)
    {

        $orderDetail = $this->orderService->getOrderDetail($orderSn);

        return view('order.payment')->with('orderDetail', $orderDetail);
    }


    //微信支付 入口
    public function wechatpay($orderSn)
    {

        $wechatPayUrl = $this->orderService->generatePayQrCode($orderSn);
        return view('order.wechatPay')->with('wechatPayUrl', $wechatPayUrl);
    }


    //支付宝支付 入口
    public function alipay($orderSn)
    {
        $payResult =  $this->orderService->processAlipay($orderSn);

    }


    //支付宝返回
    public function alipayReturn(Request $request)
    {

        $body = $request->input('body');
        $buyer_email = $request->input('buyer_email');
        $buyer_id = $request->input('buyer_id');
        $exterface = $request->input('exterface');
        $is_success = $request->input('is_success');
        $notify_id = $request->input('notify_id');
        $notify_time = $request->input('notify_time');
        $notify_type = $request->input('notify_type');
        $out_trade_no = $request->input('out_trade_no');
        $payment_type = $request->input('payment_type');
        $seller_id = $request->input('seller_id');
        $subject = $request->input('subject');
        $total_fee = $request->input('total_fee');
        $trade_no = $request->input('trade_no');
        $trade_status = $request->input('trade_status');
        $sign = $request->input('sign');
        $sign_type = $request->input('sign_type');

        dd($request->all());
    }
}
