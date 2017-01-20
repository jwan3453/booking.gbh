@extends('template.layout')

@section('resources')

    <script  type="text/javascript" src= {{ asset('js/calendar.js')}}></script>
@stop



@section('content')

    <title>订单确认</title>

    @include('partial.calender')

    <div class="order-process">
        <div class="step ">
            1.填写订单
            <div class="arrow-next "></div>
        </div>
        <div class="step ">
            2.订单支付
            <div class="arrow-next "></div>
        </div>

        <div class="step active-step">
            3.支付完成
        </div>
    </div>


    <div class="cus-container">
        <div class="payment-section">
            <ul class="order-title">
                <li><span>订单明细</span></li>

                <li>
                    <span>房型信息</span>
                </li>

                <li>
                    <span>入住日期 </span>
                </li>

                <li>
                    <span>退房时期</span>
                </li>

                <li><span>房间数量</span></li>

                <li><span>订单总额</span></li>

                <li>
                    <span>
                        订单状态
                   </span>
                </li>
            </ul>

            <ul class="order-detail">
                <li><img src="{{$orderDetail->roomDetail->imageLink}}"></li>

                <li>
                    <span class="h-name">{{$orderDetail->hotelDetail->name}}</span>
                    <span class="r-name">{{$orderDetail->roomDetail->room_name}}</span>
                </li>

                <li>
                    <span>{{ date("Y-m-d", strtotime($orderDetail->check_in_date))}} </span>
                </li>

                <li>
                    <span>{{ date("Y-m-d", strtotime($orderDetail->check_out_date))}} </span>
                </li>

                <li><span>{{$orderDetail->num_of_room}}间</span></li>

                <li><span ><span class="m-s">￥</span>{{$orderDetail->total_amount}}</span></li>

                <li>
                    <span>
                        @if($orderDetail->pay_status === 0)
                            等待支付
                        @elseif($orderDetail->pay_status === 1)
                            已支付
                        @endif
                   </span>
                </li>


            </ul>

            <div class="success-pay">
                <span class="success-note">您的订单已经支付成功</span>
                <span>支付时间: {{$orderDetail->updated_at}}</span>
                <a class="b-anchor" href="/user/myorders/orderdetail/{{$orderDetail->order_sn}}">
                   <div class="regular-btn blue-btn"> 订单详情</div>
                </a>
            </div>


        </div>
    </div>











@stop


@section('script')

    <script >

        $(document).ready(function(){
        })

    </script>

@stop

