@extends('template.layout')

@section('resources')

    <script  type="text/javascript" src= {{ asset('js/calendar.js')}}></script>
@stop



@section('content')

    <title>订单确认</title>

    @include('partial.calender')


    <div class="cus-container">
        <div class="pay-return-result">

            <div class="pay-result">

                @if($result == 1)
                    <span>订单支付成功</span>
                    <div class="pay-success icon"></div>
                @elseif($result == 0)
                    <span>订单不存在，支付失败</span>
                    <div class="pay-fail icon"></div>
                @elseif($result == 2)
                    <span>订单支付失败</span>
                    <div class="pay-fail icon"></div>
                @elseif($result == 3)
                    <span>订单信息错误,支付失败</span>
                    <div class="pay-fail icon"></div>
                @endif

            </div>

            <div class="order-brief">
                <div class="line-detail">
                    <span class="t">订单号 :</span> <span class="d">{{$orderInfo['out_trade_no']}}</span>
                </div>
                <div class="line-detail">
                    <span class="t">酒店/房型 :</span><span class="d">{{$orderInfo['subject']}}</span>
                </div>
                <div class="line-detail">
                    <span class="t">总额 :</span><span class="d">￥{{$orderInfo['total_fee']}}</span>
                </div>
                <div class="line-detail">
                    <span class="t">支付时间 :</span><span class="d">{{$orderInfo['notify_time']}}</span>
                </div>

                <div class="line-detail">
                    <span class="t">支付方式 :</span>

                    <span class="d">
                        @if($orderInfo['pay_type'] == 1)
                            支付宝
                        @elseif($orderInfo['pay_type'] == 2)
                            微信支付
                        @elseif($orderInfo['pay_type'] == 3)
                            银联支付
                        @endif
                    </span>
                </div>

            </div>

            <a href="/user/myorders/orderdetail/{{$orderInfo['out_trade_no']}}">
                <div class="regular-btn blue-btn auto-margin">
                    查看订单
                </div>
            </a>
        </div>
    </div>











@stop


@section('script')

    <script >

        $(document).ready(function(){
        })

    </script>

@stop

