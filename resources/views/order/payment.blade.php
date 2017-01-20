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
        <div class="step active-step">
            2.订单支付
            <div class="arrow-next active-arrow"></div>
        </div>

        <div class="step">
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


            <div class="pay-options">

                <div class="title">选择支付方式</div>
                <div class="pay-method" >
                    <div class="item">
                        <input type="checkbox"  class="pay-option" name="payByUnionPay" value="/payment/pay/unionpay/{{$orderDetail->order_sn}}"/>
                        <div class="unionPay pay-icon">
                        </div>
                        <div class="text"> {{trans('hotel.unionPay')}}</div>
                    </div>

                    <div  class="item">
                        <input type="checkbox"  class="pay-option"  name="payByAliPay" value="/payment/pay/alipay/{{$orderDetail->order_sn}}"/>
                        <div class="aliPay pay-icon">
                        </div>
                        <div class="text"> {{trans('hotel.aliPay')}}</div>
                    </div>

                    <div  class="item">
                        <input type="checkbox"  class="pay-option"  name="payByWechatPay" value="/payment/pay/wechatpay/{{$orderDetail->order_sn}}"/>
                        <div class="wechatPay pay-icon">
                        </div>
                        <div class="text"> {{trans('hotel.wechatPay')}}</div>
                    </div>
                </div>
            </div>


            <div class="confirm-payment">
                <div class="total-amount">
                   <span class="h" >总金额: </span> <span class="m-s">￥</span><span class="t">2399</span>
                </div>
                <a  id='payUrl' href="" target ="blank">
                    <div class="red-btn regular-btn confirm-btn" id="confirmPayBtn">
                    前往支付
                    </div>
                </a>
            </div>

        </div>
    </div>


    <div class="screen-mask">
    </div>


    <div class="pay-status-popup" id="payConfirmPopUp">
        <div class="pay-confirm">
            <h3 class="h">请在支付页面进行支付</h3>
            <div class="pay-confirm-btns">


                <a class="fail" id="failPay">
                    <div class="regular-btn outline-btn">支付遇到问题</div>
                </a>

                <a class="success " id="successPay">
                    <div class="regular-btn green-btn">支付成功</div>
                </a>

            </div>

            <div class="pay-question-list" >
                <div class="t">支付遇到问题?</div>
                <div  class="s">
                    1.支付失败,<span class="repay">重新发起支付</span>
                </div>

                <div class="s">
                    2.支付成功,查看<span class="checkAccount">我的订单</span>查看订单状态
                </div>
            </div>

            <div class="order-contact">
                如果仍旧无法支付，欢迎拨打0592-5657-31 进行咨询
            </div>
        </div>
    </div>


    <div class="pay-status-popup" id="failPayPop">
        <div class="fail-pay">
            <h3 class="h">尚未收到支付确认，需要重新支付</h3>
            <div class="pay-confirm-btns">


                <a class="acknowledge " id="acknowledge">
                    <div class="regular-btn red-btn auto-margin">哦!</div>
                </a>


            </div>

            <div class="pay-question-list" >
                <div class="t">支付遇到问题?</div>
                <div  class="s">
                    1.支付失败,<span class="repay">重新发起支付</span>
                </div>

                <div class="s">
                    2.支付成功,查看<span class="checkAccount">我的订单</span>查看订单状态
                </div>
            </div>

            <div class="order-contact">
                如果仍旧无法支付，欢迎拨打0592-5657-31 进行咨询
            </div>
        </div>
    </div>



@stop


@section('script')

    <script >

        $(document).ready(function(){


            $('.pay-option').change(function(){
                var selectPay = $(this);

                $(this).siblings('.pay-option').css('border','1px solid red;');

                $('.pay-option').each(function(){
                    if(selectPay.attr('name') != $(this).attr('name'))
                    {
                        $(this).prop('checked',false);
                        $('#payUrl').attr('href',selectPay.attr('value'));
                    }
                })
            })

            $('#confirmPayBtn').click(function(){
                $('.screen-mask').show();
                $('#payConfirmPopUp').show();
            })

            $('#failPay').click(function(){
                $('.screen-mask').hide();
                $('#payConfirmPopUp').hide();
            })
        })


        $('#successPay').click(function(){
            $.ajax({
                type: 'POST',
                url: '/checkpayment',
                dataType: 'json',
                data: {orderSn:'{{$orderDetail->order_sn}}'},
                async:false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },

                success : function(data){
                    if(data.statusCode === 1)
                    {
                        location.href='/payment/success/' + '{{$orderDetail->order_sn}}';
                    }
                    else if(data.statusCode === 2)
                    {
                        $('#payConfirmPopUp').hide();
                        $('#failPayPop').show();
                    }

                },
                error:function(){
                    //ajax 出错
                    $('#payConfirmPopUp').hide();
                    $('#failPayPop').show();
                }
            })
        })

        $('#acknowledge').click(function(){
            $('.screen-mask').hide();
            $('#failPayPop').hide();
        })

        $('.repay').click(function(){
            $('#failPayPop').hide();
            $('.screen-mask').hide();
            $('#payConfirmPopUp').hide();
        })

        $('.checkAccount').click(function(){
            location.href='/user/myorders/all';
        })
    </script>

@stop

