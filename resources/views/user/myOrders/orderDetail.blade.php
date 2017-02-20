
@extends('userLayout.blade.php')

@section('resources')


@stop



@section('user-center-right')

    <div class="order-status-bar">
        <div class="progress-item current-process">
            <div class="item">
                1
            </div>
            <span class="t">订单提交</span>
            <div class="line-right"></div>
        </div>

        <div class="progress-item current-process">

            <div class="item">
                2
            </div>
            <span class="t">付款成功</span>
            <div class="line-left"></div>
            <div class="line-right"></div>
        </div>

        <div class="progress-item">
            <div class="item">
               3
            </div>
            <span class="t">订单确认</span>
            <div class="line-left"></div>
            <div class="line-right"></div>
        </div>

        <div class="progress-item">
            <div class="item">
                4
            </div>
            <span class="t">入住</span>
            <div class="line-left"></div>
        </div>

    </div>


    <ul class="myOrder-detail">


        <li>
            <div class="h">订单详情</div>
            <div class="d">
                <div><span>订单编号: {{$orderDetail->order_sn}}</span></div>
                <div><span>下单时间: {{$orderDetail->created_at}}</span></div>
            </div>
        </li>

        <li>
            <div class="h">酒店详情</div>

            <img src="{{$orderDetail->roomDetail->imageLink}}">
            <div class="h-t">
                <span class="h-name">{{$orderDetail->hotelDetail->name}}</span>
                <span class="r-name">{{$orderDetail->roomDetail->room_name}}</span>
                <span class="h-address">
                        @if(session('lang') == 'en')
                        {{$orderDetail->hotelDetail->address->detail_en}} {{$orderDetail->hotelDetail->city->city_name_en}} {{$orderDetail->hotelDetail->province->province_name_en}}{{$orderDetail->hotelDetail->province->name_en}}
                    @else
                        {{$orderDetail->hotelDetail->province->name}}{{$orderDetail->hotelDetail->province->province_name}}{{$orderDetail->hotelDetail->city->city_name}}{{$orderDetail->hotelDetail->district=''?$orderDetail->hotelDetail->district->district_name:'' }}{{$orderDetail->hotelDetail->address->detail}}

                    @endif

                </span>
            </div>
        </li>

        <li>
            <div class="h">入住详情</div>

            <div class="check-in-detail">
                <div >
                    <span>入住时间:  {{ date("Y-m-d", strtotime($orderDetail->check_in_date))}}</span>
                    <span>退房时间:  {{ date("Y-m-d", strtotime($orderDetail->check_out_date))}}</span>
                </div>
                <div >
                    <span>入住天数:  {{ $orderDetail->dateDiff}}</span>
                    <span>房间数量:  {{$orderDetail->num_of_room}}</span>
                </div>
            </div>


        </li>


        <li>
            <div class="h">客人名单</div>
            <div class="check-in-guest-list">
                @foreach(explode('|', $orderDetail->guest_list) as $guest)
                    <span>{{$guest}}</span>
                @endforeach
            </div>
        </li>

        <li>
            <div class="h">订单金额</div>
            <div class="d">

                <div>房间均价: ￥{{$orderDetail->average_price}}</div>
                <div>订单总价: ￥{{$orderDetail->total_amount}}</div>

            </div>
        </li>

        <li>
            <div class="h">订单状态</div>
                    <span>
                        @if($orderDetail->pay_status === 0)
                            等待支付
                        @elseif($orderDetail->pay_status === 1)
                            已支付
                        @endif
                   </span>
        </li>
    </ul>



@stop


