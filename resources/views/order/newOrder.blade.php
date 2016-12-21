@extends('template.layout')

@section('resources')

    <script  type="text/javascript" src= {{ asset('js/calendar.js')}}></script>
@stop



@section('content')

    <title>订单确认</title>

    @include('partial.calender')

    <div class="order-process">
        <div class="step">
            1.填写订单
            <div class="arrow-next"></div>
        </div>
        <div class="step active-step">
            2.订单支付
            <div class="arrow-next active-arrow"></div>
        </div>

        <div class="step">
            3.支付完成
        </div>
    </div>

    <div class="fill-order-detail">


            <form class="order-detail-form">
                <div class="order-line-detail">
                    <div class="header">预定信息</div>

                    <div style="margin-top:20px;">
                        <div class="order-sub-line-detail">
                            <div class="sub-header">入住日期</div>
                            <div class="detail order-checkInOut-date">
                                <input class="check-in-date date-input" name="checkInDate" id="checkInDate" type="text" placeholder="入住日期"  readonly/>
                                <hr>
                                <input class="check-out-date date-input" name="checkOutDate" id="checkOutDate" type="text" placeholder="离店日期" readonly/>
                            </div>
                        </div>

                        <div class="order-sub-line-detail">
                            <div class="sub-header">房间数量</div>
                            <div class="detail order-nor "  >
                                <input name="nor" id="nor" type="text" placeholder="1间"  readonly/>
                                <ul id="selectNor" class="select-nor">
                                    <li>1 间</li>
                                    <li>2 间</li>
                                    <li>3 间</li>
                                    <li>4 间</li>
                                    <li>5 间</li>
                                    <li>6 间</li>
                                    <li>7 间</li>
                                    <li>8 间</li>
                                    <li>9 间</li>
                                    <li>10 间</li>
                                </ul>
                            </div>
                        </div>

                        <div class="order-sub-line-detail">
                            <div class="sub-header">住客姓名</div>
                            <div class="detail order-guest-info "   id="orderGuestInfo">
                                <input class="guest-info" name="guestInfo[]" type="text" placeholder="住客1"  />




                            </div>
                        </div>

                    </div>

                </div>


                <div class="order-line-detail">
                    <div class="header">订单联系人</div>

                    <div style="margin-top:20px;">
                        <div class="order-sub-line-detail">
                            <div class="sub-header">手机号码</div>
                            <div class="detail contact-detail " >
                                <input  name="contactPhone" id="contactPhone" type="text"  />
                            </div>
                        </div>
                        <div class="order-sub-line-detail">
                            <div class="sub-header">联系邮箱</div>
                            <div class="detail contact-detail "  >
                                <input  name="contactEmail" id="contactEmail" type="text"  />
                            </div>
                        </div>

                    </div>

                </div>


            </form>

            <div class="room-detail">
                <img src="{{$hotelRoomDetail['room']->imageLink}}">
                <div class="hotel-basic-info">
                    <h3 class="name">
                        {{$hotelRoomDetail['hotel']->name}}
                    </h3>

                    <div class="address">
                        @if(session('lang') == 'en')
                            {{$hotelRoomDetail['hotel']->address->detail_en}} {{$hotelRoomDetail['hotel']->city->city_name_en}} {{$hotelRoomDetail['hotel']->province->province_name_en}}{{$hotelRoomDetail['hotel']->province->name_en}}
                        @else
                            {{$hotelRoomDetail['hotel']->province->name}}{{$hotelRoomDetail['hotel']->province->province_name}}{{$hotelRoomDetail['hotel']->city->city_name}}{{$hotelRoomDetail['hotel']->district=''?$hotelRoomDetail['hotel']->district->district_name:'' }}{{$hotelRoomDetail['hotel']->address->detail}}

                        @endif
                    </div>
                </div>

                <div class="room-basic-info">

                    <h4 class="name"> {{$hotelRoomDetail['room']->room_name}}</h4>
                    <div  class="basic-attribute-list">
                        <div class="attribute">
                            <span class="attribute-name">早餐: </span>
                            <span>
                                    {{$hotelRoomDetail['room']->num_of_breakfast}}份
                            </span>
                         </div>

                        <div class="attribute">
                            <span class="attribute-name">房型大小: </span>
                            <span>
                                    {{$hotelRoomDetail['room']->acreage}} m²
                            </span>
                        </div>



                        <div class="attribute">
                            <span class="attribute-name">无线wifi:</span>
                            <span>
                             @if($hotelRoomDetail['room']->wifi == 0)
                                {{trans('hotel.noWifi')}};
                            @elseif($hotelRoomDetail['room']->wifi == 1)
                               {{trans('hotel.wifiWithCharge')}}
                            @else
                               {{trans('hotel.freeWifi')}}
                            @endif
                            </span>
                        </div>



                        <div class="attribute">
                            <span class="attribute-name">加床: </span>
                            <span>
                                @if($hotelRoomDetail['room']->is_extra_bed == 0)
                                    {{trans('hotel.noExtraBed')}}
                                @elseif($hotelRoomDetail['room']->is_extra_bed == 1)
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
                        <div class="p"><span class="m-s">￥</span><span class="total">{{$hotelRoomDetail['averagePrice']}}</span></div>
                    </div>


                    <div class="offer-info">
                        <span class="room-night"> {{$hotelRoomDetail['dateDiff']}} 晚</span>

                        <span class="nop-offer"><span id="nopOffer">1</span> 间客房</span>
                    </div>


                    <div class="offer-price">
                        <span class="t">总计</span>
                        <div class="p"><span class="m-s">￥</span><span class="total">{{$hotelRoomDetail['totalAmount']}}</span></div>
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

            $('.select-nor  li').click(function(){

                $('#nor').val($(this).text());



                //选择的间数
                var nor = $(this).index()+1 ;
                $('#nopOffer').text(nor);

                //基本入住人数为两位
                var startNop = 0;
                $('#selectNor').hide();
                $('#orderGuestInfo').empty();

                for(var i=0 ; i< nor; i++)
                {
                    $('#orderGuestInfo').append('<input class="guest-info" name="guestInfo[]" type="text" placeholder="住客'+(++startNop)+'"  />');

                }

            })


            //点击关闭日历 关闭数量选择框
            $(document).bind("click",function(e){

                //点击隐藏日历
                e = e || window.event;
                var target = $(e.target);
                var test = target.parents();
//
//                if((target.closest($('#calendar')).length == 0 &&target.closest($('#searchDateBox')).length == 0)   && target.parents().length !==0){
//
//                    $('#calendar').hide();
//                }


                if((target.closest($('#nor')).length == 0 &&target.closest($('#selectNor')).length == 0)   ){
                        $('#selectNor').hide();
                }


            });

        })

        function searchPriceByNewDate()
        {
            $('#calendar').hide();
            alert('test');
//            $.ajax({
//                type: 'POST',
//                url: '/searchPriceByDate',
//                dataType: 'json',
//                data: {},
//                async:true,
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                },
////                beforeSend:function(){
//////                    $('#searchRoomLoader').transition('fade');
////                },
//                success : function(data){
//                    if(data.statusCode === 1)
//                        {
//                            alert('success');
//                    }
//                    else{
//
//                    }
//                   // $('#searchRoomLoader').transition('fade');
//
//                },
//                error:function(){
//                  //  $('#searchRoomLoader').transition('fade');
//
//                }
//            })

        }

    </script>

@stop

