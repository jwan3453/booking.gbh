@extends('template.layout')

@section('resources')


@stop



@section('content')

    <title>{{trans('destination.destination')}}</title>



    <div class="choose-area" id="chooseArea">
        {{trans('destination.area')}}
    </div>

    <!-- 国内区域-->
    <div class="dest-list auto-margin">

        <div class="area-list" id="areaList">


            <div class="area-header">
                <span class="p"></span>
                <span>{{trans('destination.domestic')}}</span>
            </div>
            @if($destinationList['adgList'])
            <div class="area"  id="10000">
                <div class="p"></div>
                <span>{{ trans('destination.municipality') }}</span>
            </div>
            @endif
            @foreach($destinationList['provinceList'] as $province )
                <div class="area" id="{{$province->code}}">
                    <div class="p"></div>
                    <span>

                        @if(session('lang') == 'en')
                            {{$province->province_name_en}}
                        @else

                            {{$province->province_name}}
                        @endif
                    </span>
                </div>
            @endforeach

            <div class="area-header">
                <span class="p"></span>
                <span> {{trans('destination.international')}}</span>
            </div>
            @foreach($destinationList['continent'] as $continent )

                @if(count($continent->cityList) > 0)
                <div class="area" id="{{$continent->id}}">
                    <div class="p"></div>
                        <span>

                            @if(session('lang') == 'en')
                                {{$continent->name_en}}
                            @else

                                {{$continent->name}}
                            @endif
                        </span>
                </div>
                @endif
            @endforeach

        </div>




        {{--<div class="ui dropdown mobi-province-list">--}}
            {{--<div class="text">选择省份</div>--}}
            {{--<i class="dropdown icon"></i>--}}
            {{--<div class="menu">--}}
                {{--<div class="item">直辖市</div>--}}
                {{--@foreach($destinationList['provinceList'] as $province )--}}
                    {{--<div class="item" id="{{$province->code}}">{{$province->province_name}}</div>--}}
                {{--@endforeach--}}
            {{--</div>--}}
        {{--</div>--}}

        @if($destinationList['adgList'])
        <div class="area-section">
            <div class="ui horizontal divider  area-name" id="area_10000">
                {{ trans('destination.municipality') }}
            </div>


            <div class="city-list">
                @foreach($destinationList['adgList'] as $city)
                    <div class="city auto-margin flap-animation" style="visibility: visible;animation-delay:0.1s;animation-name:fadeInUp;">
                        <div class="cover-image">

                            <span class="city-name">
                                @if(session('lang') == 'en')
                                    {{$city->city_name_en}}
                                @else

                                    {{$city->city_name}}
                                @endif
                            </span>
                            <img src ="{{$city->cover_image}}"/>
                        </div>
                        <a href="/hotelByCity/ds/{{$city->code}}">
                            <div class="city-mask ">
                                <div class="num-of-hotel">
                                    {{ trans('destination.total') }}<span>{{$city->num_of_hotel}}</span>{{ trans('destination.hotels') }}
                                </div>

                                <div class="desc">
                                    @if(session('lang') == 'en')
                                        {{$city->description_en}}
                                    @else

                                        {{$city->description}}
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
        @endif


        @foreach($destinationList['provinceList'] as $province )
        <div class="prov-section">

            <div class="ui horizontal divider  area-name" id="area_{{$province->code}}">
                @if(session('lang') == 'en')
                    {{$province->province_name_en}}
                @else

                    {{$province->province_name}}
                @endif
            </div>



            <div class="city-list">
                @foreach($province->cityList as $city)
                    <div class="city auto-margin flap-animation">
                        <div class="cover-image ">

                            <span class="city-name">
                                @if(session('lang') == 'en')
                                    {{$city->city_name_en}}
                                @else

                                    {{$city->city_name}}
                                @endif
                            </span>
                            <img src ="{{$city->cover_image}}"/>
                        </div>

                        <a href="/hotelByCity/ds/{{$city->code}}">
                                <div class="city-mask ">
                                <div class="num-of-hotel">
                                    {{ trans('destination.total') }}<span>{{$city->num_of_hotel}} </span>{{ trans('destination.hotels') }}
                                </div>

                                <div class="desc">
                                    @if(session('lang') == 'en')
                                        {{$city->description_en}}
                                    @else

                                        {{$city->description}}
                                    @endif
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>


    <!-- 国外区域-->
    <div class="dest-list auto-margin">



        @foreach($destinationList['continent'] as $continent )
            @if(count($continent->cityList)>0)
                <div class="area-section">
                    <div class="ui horizontal divider  area-name" id="area_{{$continent->id}}">
                    @if(session('lang') == 'en')
                        {{$continent->name_en}}
                    @else

                        {{$continent->name}}
                    @endif
                </div>



                <div class="city-list">
                    @foreach($continent->cityList as $city)

                        <div class="city auto-margin flap-animation">
                            <div class="cover-image ">

                            <span class="city-name">
                                @if(session('lang') == 'en')
                                    {{$city->city_name_en}}
                                @else

                                    {{$city->city_name}}
                                @endif
                            </span>
                                <img src ="{{$city->cover_image}}"/>
                            </div>
                            <a href="/hotelByCity/int/{{$city->code}}">
                            <div class="city-mask ">
                                <div class="num-of-hotel">
                                    {{ trans('destination.total') }}<span>{{$city->num_of_hotel}} </span>{{ trans('destination.hotels') }}
                                </div>

                                <div class="desc">
                                    @if(session('lang') == 'en')
                                        {{$city->description_en}}
                                    @else

                                        {{$city->description}}
                                    @endif
                                </div>
                            </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
            @endif
        @endforeach

    </div>

    <div class="mobi-area-list" id="mobiArea">

        <i class="icon remove  circle big" id="closeAreaMenu"></i>
        <h4 >{{trans('destination.domestic')}}</h4>

        <div class="area">{{ trans('destination.municipality') }}</div>
        @foreach($destinationList['provinceList'] as $province )
             <div class="area" id="{{$province->code}}">

                 @if(session('lang') == 'en')
                     {{$province->province_name_en}}
                 @else

                     {{$province->province_name}}
                 @endif
             </div>
        @endforeach

        <h4 >{{trans('destination.international')}}</h4>
        @foreach($destinationList['continent'] as $continent )

            @if(count($continent->cityList) > 0)
                <div class="area" id="{{$continent->id}}">

                    @if(session('lang') == 'en')
                        {{$continent->name_en}}
                    @else

                        {{$continent->name}}
                     @endif

                </div>
            @endif
        @endforeach


    </div>
@stop




@section('script')

    <script >

        $(document).ready(function(){


            $('.ui.dropdown')
                    .dropdown()
            ;


            $('#chooseArea').click(function(){
                    $('#mobiArea').transition('drop');
            })

            $('#closeAreaMenu').click(function(){
                $('#mobiArea').transition('drop');
            })



            $('.city').hover(function() {

                    $(this).find('.city-name').fadeOut(400);
                    $(this).find('.num-of-hotel').stop().animate({top: 0}, 400, function () {

                    })

                    $(this).find('.desc').stop().animate({bottom: 0}, 400, function () {

                    })
                },
                function(){
                    $(this).find('.city-name').fadeIn(400);
                    $(this).find('.num-of-hotel').stop().animate({top: -100}, 400, function () {

                    })

                    $(this).find('.desc').stop().animate({bottom: -150}, 400, function () {

                    })

            })

            $('.area ').hover(function() {

                        $(this).find('.p').stop().show().animate({left: 10}, 200, function () {

                        })
                    },
                    function(){
                        $(this).find('.p').stop().show().animate({left: -10}, 200, function () {
                            $(this).fadeOut(100);
                        })
                    })

            })

            $('.area').click(function(){

                $("html,body").animate({scrollTop:$("#area_"+$(this).attr('id')).offset().top-80},1000);

            })


        var timeout;
        $(window).scroll(function() {

            clearTimeout(timeout);
            timeout = setTimeout(function() {

                if($(this).scrollTop()> 50)
                {
                    $('#areaList').addClass('area-list-fixed');
                }
                else{
                    $('#areaList').removeClass('area-list-fixed');
                }
                $('.city').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top-600 ) {

                        if($(this).css('visibility') === 'hidden')
                        {
                            $(this).css('visibility','visible').css('animation-delay','0.1s').css('animation-name','fadeInUp');
                        }

                    }
                })

            }, 10);

        });


    </script>
@stop