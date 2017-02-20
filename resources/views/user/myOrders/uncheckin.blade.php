
@extends('userLayout.blade.php')

@section('resources')


@stop



@section('user-center-right')
    <div class="order-filter">
        <a href="/user/myorders/all">全部订单</a>
        <a href="/user/myorders/unpaid">待支付</a>
        <a class="selected-filter"  href="/user/myorders/uncheckin">未入住</a>
        <a href="/user/myorders/unconfirmed">待确认</a>
        <a href="/user/myorders/canceled">已取消</a>
    </div>


    <ul class="order-info-title">
        <li>酒店信息</li>
        <li>入住日期</li>
        <li>间数</li>

        <li>总额</li>
        <li>订单状态</li>
        <li>操作</li>
    </ul>



    @if(count($orders) > 0)

        @foreach($orders as $order)
            <ul class="order-info-line">

                <li><img src="{{$order->detail->roomDetail->imageLink}}">
                <li>
                    <span class="h-name">{{$order->detail->hotelDetail->name}}</span>
                    <span class="r-name">{{$order->detail->roomDetail->room_name}}</span>
                </li>

                <li>
                    <span class="r">{{ date("Y-m-d", strtotime($order->detail->check_in_date))}}  </span>
                    <span class="l">{{ date("Y-m-d", strtotime($order->detail->check_out_date))}}  </span>
                </li>

                <li><span>{{$order->detail->num_of_room}}间</span></li>

                <li><span ><span class="m-s">￥</span>{{$order->detail->total_amount}}</span></li>

                <li>
                    已支付
                </li>

                <li>
                    <a class="b-anchor" href="/user/myorders/orderdetail/{{$order->detail->order_sn}}">订单详情</a>
                </li>

                <li>
                    <span>订单号:</span>
                    <span>{{$order->detail->order_sn}}</span>
                </li>
            </ul>
        @endforeach
    @else

        <div class="no-orders"><div class="no-records-icon" ></div><span>没有订单</span></div>
    @endif


@stop


