@extends('template.layout')

@section('resources')



@stop



@section('content')

    <title> {{ trans('hotelByCity.title') }}</title>



    <div class="cate-city-hotel auto-margin">


        <div class= " ui horizontal divider cate-city-name">
            @if(session('lang') == 'en')
            {{$hotel['cityName']->city_name_en}}
            @else
                {{$hotel['cityName']->city_name}}
            @endif
            {{trans('hotelByCity.sHotel')}}
        </div>

        <div class="cate-hotel-list auto-margin">
            @if($hotel['list'])
            @foreach($hotel['list'] as $hotel)
                <div class="cate-hotel-detail">
                    <div class="cover-image">
                        <img class="trans_fast" src="{{$hotel->link}}">
                        <div >
                            <h3>
                                @if(session('lang') == 'en')
                                    {{$hotel->name_en}}
                                @else
                                    {{$hotel->name}}
                                @endif</h3>
                            <p><span class="price-from-text">{{ trans('hotelByCity.enFrom') }}{{ trans('home.currency') }}</span>{{$hotel->priceFrom}} <span class="price-from-text">{{ trans('hotelByCity.zhFrom') }}</span></p>
                        </div>
                    </div>

                    <a href="/hotel/{{$hotel->code}}">
                        <div class="text-detail trans_fast">

                    <span class="feature">

                        @if(session('lang') == 'en')
                             {{$hotel->hotel_features_en}}
                         @else
                             {{$hotel->hotel_features}}
                         @endif


                    </span>
                    <span class="address"><i class="icon marker"></i>
                        @if(session('lang') == 'en')
                            {{$hotel->detail_en}} {{$hotel->city_name_en}}
                            @if(isset($hotel->province_name_en))
                                {{$hotel->province_name_en}}
                            @endif
                        @else
                            @if(isset($hotel->province_name))
                                {{$hotel->province_name}}
                            @endif
                            {{$hotel->city_name}}{{$hotel->detail}}
                        @endif
                    </span>
                    <div class="regular-btn red-btn auto-margin">{{ trans('hotelByCity.view') }}</div>
                    </div>
                    </a>
                </div>
            @endforeach
            @else
                <div class="no-hotel-list">
                    <h2>该地区暂无酒店</h2>
                </div>
            @endif
        </div>





    </div>
@stop




@section('script')

    <script >

        $(document).ready(function(){

            if($(document).width() > 767)
            {
                $('.text-detail').addClass('draw');
            }

        })
        var pattern = Trianglify({
            width: $(window).width(),
            height: $(window).height(),
            cell_size: 40});

        document.getElementById('contentSection').appendChild(pattern.canvas());

    </script>
@stop