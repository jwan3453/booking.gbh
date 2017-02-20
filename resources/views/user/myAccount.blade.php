
@extends('user.userLayout.php')

@section('resources')


@stop



@section('user-center-right')
    <div class="account-detail">
        <div class="h">我的账户详情</div>

        <div class="d">
            <div class="account-item">
                <span>支付总额:</span>
                <span>￥24500</span>
            </div>

            <div class="account-item">
                <span>完成订单:</span>
                <span>15 单</span>
            </div>
        </div>


        <div class="d">
            <div class="account-item">
                <span>账户余额:</span>
                <span>￥1230</span>
            </div>


        </div>

        <div class="year-summary">
           <div> <span >您在2017年一共入住了<span class="statistic"> 4 </span>家酒店,</span>
               <span >提交了<span class="statistic"> 6 </span></span>个订单,
               <span >花费了<span class="statistic"> ￥12000  </span></span>
           </div>
            <div class="ys-line"> </div>
            <div class="ys-line"> </div>
        </div>
    </div>
@stop


