@extends('template.layout')

@section('resources')

    <script  type="text/javascript" src= {{ asset('js/calendar.js')}}></script>
@stop



@section('content')

    <title>订单确认</title>

    @include('partial.calender')

    <div class="order-process">
        <div class="step active-step">
            1.填写订单
            <div class="arrow-next active-arrow"></div>
        </div>
        <div class="step ">
            2.订单支付
            <div class="arrow-next "></div>
        </div>

        <div class="step">
            3.支付完成
        </div>
    </div>

    <div class="fill-order-detail c">
            <form class="order-form" action="/createOrder" method="post" id="orderForm">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="room"   value="{{$offerDetail['room']->id}}">
                <input type="hidden" name="hotel" value="{{$offerDetail['hotel']->id}}">

                <div class="order-line-detail">
                    <div class="header">预定信息</div>

                    <div style="margin-top:20px;">
                        <div class="order-sub-line-detail" id="searchDateBox">
                            <div class="sub-header">入住日期</div>
                            <div class="detail order-checkInOut-date">
                                <input class="check-in-date date-input" name="checkInDate" id="checkInDate" type="text" placeholder="入住日期" value="{{$offerDetail['checkInDate']}}"  readonly/>
                                <hr>
                                <input class="check-out-date date-input" name="checkOutDate" id="checkOutDate" type="text" placeholder="离店日期" value="{{$offerDetail['checkOutDate']}}" readonly/>
                            </div>
                        </div>

                        <div class="order-sub-line-detail">
                            <div class="sub-header">房间数量</div>
                            <div class="detail order-nor "  >
                                <input name="maxBookingNum" id="maxBookingNum" type="hidden" value="{{$offerDetail['maxBookingNum']}}">
                                <input name="roomNum" id="roomNum" type="hidden" value="1">
                                <input id="nor" type="text" placeholder="1间"  readonly/>
                                <ul id="selectNor" class="select-nor">
                                    @for($i=1; $i<=$offerDetail['maxBookingNum']; $i++)
                                        <li>{{ $i}} 间</li>
                                    @endfor

                                </ul>
                            </div>
                        </div>

                        <div class="order-sub-line-detail">
                            <div class="sub-header guest-n-h">住客姓名</div>
                            <div class="detail order-guest-info "   id="orderGuestInfo">
                                <input class="guest-info" name="guestInfo[]" type="text" placeholder="住客1"  />
                                <div class="error-message-info order-input-error" id="emtGuestInfo">请输入住客信息 </div>
                            </div>

                        </div>

                    </div>

                </div>


                <div class="order-line-detail">
                    <div class="header">订单联系人</div>

                    <div style="margin-top:20px;">
                        <div class="order-sub-line-detail">
                            <span class="r-marker">*</span>
                            <div class="sub-header">   手机号码 </div>
                            <div class="detail contact-detail " >
                                <input  name="contactPhone" id="contactPhone" type="text"  />
                            </div>
                            <div class="error-message-info order-input-error" id="wrongPhoneNo">请输入正确的手机号 </div>
                        </div>
                        <div class="order-sub-line-detail">
                            <span class="r-marker">*</span>
                            <div class="sub-header">  联系邮箱</div>
                            <div class="detail contact-detail "  >
                                <input  name="contactEmail" id="contactEmail" type="text"  />
                            </div>
                            <div class="error-message-info order-input-error" id="wrongEmail">请输入正确的邮箱 </div>
                        </div>

                    </div>

                </div>


                <div class="submit-order" id="submitOrder">
                    提交订单
                </div>

            </form>

            <div class="room-detail">
                <img src="{{$offerDetail['room']->imageLink}}">
                <div class="hotel-basic-info">
                    <h3 class="name">
                        {{$offerDetail['hotel']->name}}
                    </h3>

                    <div class="address">
                        @if(session('lang') == 'en')
                            {{$offerDetail['hotel']->address->detail_en}} {{$offerDetail['hotel']->city->city_name_en}} {{$offerDetail['hotel']->province->province_name_en}}{{$offerDetail['hotel']->province->name_en}}
                        @else
                            {{$offerDetail['hotel']->province->name}}{{$offerDetail['hotel']->province->province_name}}{{$offerDetail['hotel']->city->city_name}}{{$offerDetail['hotel']->district=''?$offerDetail['hotel']->district->district_name:'' }}{{$offerDetail['hotel']->address->detail}}

                        @endif
                    </div>
                </div>

                <div class="room-basic-info">

                    <h4 class="name"> {{$offerDetail['room']->room_name}}</h4>
                    <div  class="basic-attribute-list">
                        <div class="attribute">
                            <span class="attribute-name">早餐: </span>
                            <span>
                                    {{$offerDetail['room']->num_of_breakfast}}份
                            </span>
                         </div>

                        <div class="attribute">
                            <span class="attribute-name">房型大小: </span>
                            <span>
                                    {{$offerDetail['room']->acreage}} m²
                            </span>
                        </div>



                        <div class="attribute">
                            <span class="attribute-name">无线wifi:</span>
                            <span>
                             @if($offerDetail['room']->wifi == 0)
                                {{trans('hotel.noWifi')}};
                            @elseif($offerDetail['room']->wifi == 1)
                               {{trans('hotel.wifiWithCharge')}}
                            @else
                               {{trans('hotel.freeWifi')}}
                            @endif
                            </span>
                        </div>



                        <div class="attribute">
                            <span class="attribute-name">加床: </span>
                            <span>
                                @if($offerDetail['room']->is_extra_bed == 0)
                                    {{trans('hotel.noExtraBed')}}
                                @elseif($offerDetail['room']->is_extra_bed == 1)
                                    {{trans('hotel.extraBedWithCharge')}}
                                @else
                                   {{trans('hotel.freeExtraBed')}}
                                @endif
                            </span>
                        </div>


                    </div>

                </div>


                <div class="offer-detail">

                    <div class="average-price">
                        <span class="t">均价</span>
                        <div class="p"><span class="m-s">￥</span><span class="total" id="averagePrice">{{$offerDetail['averagePrice']}}</span></div>
                    </div>


                    <div class="offer-info">
                        <span class="room-night"><span id="nornOffer"> {{$offerDetail['dateDiff']}}</span> 晚</span>

                        <span class="nop-offer"><span id="nopOffer">1</span> 间客房</span>
                    </div>


                    <div class="offer-price">
                        <span class="t">总计</span>
                        <div class="p"><span class="m-s">￥</span><span class="total" id="totalAmount">{{$offerDetail['totalAmount']}}</span></div>
                    </div>
                </div>


            </div>

    </div>



@stop


@section('script')

    <script >

        $(document).ready(function(){


            //选择日期
            $('#checkInDate').showCalendar($('#checkOutDate'),1);


            //选择房间数量
            $('#nor').click(function(){
                $('#selectNor').css({'margin':'0'}).show();
            })

            //选择要预定的房间数量
            $(document).on('click','.select-nor  li',function(){

                $('#nor').val($(this).text());

                //选择的间数
                var nor = $(this).index()+1 ;
                $('#nopOffer').text(nor);
                $('#roomNum').val(nor);

                //基本入住人数为两位
                var startNop = 0;
                $('#selectNor').hide();
                $('#orderGuestInfo').empty();

                //动态重构客人名单
                for(var i=0 ; i< nor; i++)
                {
                    $('#orderGuestInfo').append('<input class="guest-info" name="guestInfo[]" type="text" placeholder="住客'+(++startNop)+'"  />');

                }
                $('#orderGuestInfo').append('<div class="error-message-info order-input-error" id="emtGuestInfo" >请输入住客信息 </div>');
                //更见房间数量重新加载
                searchPriceByNewDate();

            })


            //点击关闭日历 关闭数量选择框
            $(document).bind("click",function(e){

                //点击隐藏日历
                e = e || window.event;
                var target = $(e.target);
                var test = target.parents();
//
                if((target.closest($('#calendar')).length == 0 &&target.closest($('#searchDateBox')).length == 0)   && target.parents().length !==0){

                   $('#calendar').hide();
                }


                if((target.closest($('#nor')).length == 0 &&target.closest($('#selectNor')).length == 0)   ){
                        $('#selectNor').hide();
                }


            });



            //提交订单
            $('#submitOrder').click(function(){
                var validForm = true;
                validForm = checkOrderForm();
                alert(validForm);
                if(validForm)
                {

                }
            })

        })

        //搜索房价 房态
        function searchPriceByNewDate()
        {
            $('#calendar').hide();
            $.ajax({
                type: 'POST',
                url: '/searchPriceByDate',
                dataType: 'json',
                data: {hotel:'{{$offerDetail['hotel']->id}}',room:'{{$offerDetail['room']->id}}',checkInDate:$('#checkInDate').val(),
                       checkOutDate:$('#checkOutDate').val(),numOfRoom:$('#nopOffer').text()},
                async:true,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
//                beforeSend:function(){
////                    $('#searchRoomLoader').transition('fade');
//                },
                success : function(data){
                    if(data.statusCode === 1)
                    {

                            //更新房间均价 和 总价
                            $('#averagePrice').text(parseInt(data.extra['averagePrice']));
                            $('#totalAmount').text(parseInt(data.extra['totalAmount']));

                            //更新可定房间数量list
                            var nopList ='';

                            for(var i=1; i<=parseInt(data.extra['maxBookingNum']); i++)
                            {
                                nopList += ' <li>'+i +'间</li>';
                            }
                            $('#selectNor').empty().append(nopList);
                            $('#nornOffer').text(data.extra['dateDiff']);


                        if(parseInt(data.extra['exceedNum'])  > 0 )
                        {
                            //如果需求房间数量大于可定房间数量
                            //动态重构客人名单

                            var guestListHtml = '';
                            for(var i=1; i<=parseInt(data.extra['maxBookingNum']); i++)
                            {
                                guestListHtml += '<input class="guest-info" name="guestInfo[]" type="text" placeholder="住客'+i+'"  />';
                            }
                            $('#orderGuestInfo').empty().append(guestListHtml).append('<div class="error-message-info order-input-error" id="emtGuestInfo">请输入住客信息 </div>');

                            //更新房间数 间夜数
                            $('#nor').val(data.extra['maxBookingNum'] + '间');
                            $('#nopOffer').text(data.extra['maxBookingNum']);
                            $('#roomNum').val(data.extra['maxBookingNum']);

                            //提示可定房间数量
                            toastAlert('该时间段只有'+data.extra['maxBookingNum']+'间房可预定',2);
                        }

                    }
                    else{

                    }
                   // $('#searchRoomLoader').transition('fade');

                },
                error:function(){
                  //  $('#searchRoomLoader').transition('fade');

                }
            })

        }


        function checkOrderForm()
        {
            var validOrderForm = 1;
            $('.guest-info').each(function(){
                if($(this).val() === '')
                {
                    validOrderForm =0;
                    $(this).addClass('wrong-input').siblings('.order-input-error').show();
                }
                else{
                    $(this).removeClass('wrong-input')
                }

                if(validOrderForm)
                {
                    $('#emtGuestInfo').hide();
                }

                //检查手机号 邮箱
                if($('#contactPhone').val() === '')
                {
                    validOrderForm =0;
                    $('#wrongPhoneNo').css('display','inline-block');
                }
                else{
                    $('#wrongPhoneNo').css('display','none');
                }

                if($('#contactEmail').val() === '')
                {
                    validOrderForm =0;
                    $('#wrongEmail').css('display','inline-block');
                }else{
                    $('#wrongEmail').css('display','none');
                }


                if(validOrderForm)
                {
                    $('#orderForm').submit();
                }

                return validOrderForm;

            })
        }

    </script>

@stop

