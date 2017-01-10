
@extends('user.userLayOut')

@section('resources')


@stop



@section('user-center-right')
    <div class="order-filter">
        <a class="selected-filter" href="/user/myorders/all">全部订单</a>
        <a href="/user/myorders/unpaid">待支付</a>
        <a href="/user/myorders/uncheckin">未入住</a>
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

    <ul class="order-info-line">

        <li><img src="http://7xw0sv.com1.z0.glb.clouddn.com/hotelImage/1/39/5822f25e33e38.png"></li>

        <li>
            <span class="h-name">杭州西轩天堂酒啊实打实大苏打店</span>
            <span class="r-name">商务海景大床房</span>
        </li>

        <li>
            <span class="r">2016-12-31 </span>
            <span class="l">2016-12-31 </span>
        </li>

        <li><span>2间</span></li>

        <li><span ><span class="m-s">￥</span>12344</span></li>

        <li>
            已支付
        </li>
        <li>
            <span href="#">订单详情</span>
        </li>

        <li>
            <span>订单号:</span>
            <span>1233211234567</span>
        </li>
    </ul>


    <ul class="order-info-line">

        <li><img src="http://7xw0sv.com1.z0.glb.clouddn.com/hotelImage/1/39/5822f25e33e38.png"></li>

        <li>
            <span class="h-name">杭州西轩天堂酒啊实打实大苏打店</span>
            <span class="r-name">商务海景大床房</span>
        </li>

        <li>
            <span class="r">2016-12-31 </span>
            <span class="l">2016-12-31 </span>
        </li>

        <li><span>2间</span></li>

        <li><span ><span class="m-s">￥</span>12344</span></li>

        <li>
            已支付
        </li>
        <li>
            <span href="#">订单详情</span>
        </li>

        <li>
            <span>订单号:</span>
            <span>1233211234567</span>
        </li>
    </ul>


@stop


