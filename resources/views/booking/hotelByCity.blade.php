@extends('template.layout')

@section('resources')

    <script src="/js/parallax/parallax.min.js"></script>
    <script src="/js/triang.min.js"></script>

@stop



@section('content')

    <title> {{ trans('hotel.title') }}</title>



    <div class="cate-city-hotel auto-margin">



        <div class="cate-city-name">
            @if(session('lang') == 'en')
            {{$hotel['cityName']->city_name_en}}
            @else
                {{$hotel['cityName']->city_name}}
            @endif
            {{trans('hotelByCity.sHotel')}}
        </div>

        <div class="cate-hotel-list auto-margin">
            @foreach($hotel['list'] as $hotel)
                <div class="cate-hotel-detail">
                    <div class="cover-image">
                        <img class="trans_fast" src="{{$hotel->link}}">
                        <div >
                            <h2>{{$hotel->name}}</h2>
                            <p>￥12299 <span>{{ trans('hotelByCity.from') }}</span></p>
                        </div>
                    </div>
                    <div class="connect-line"></div>
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
                            {{$hotel->detail_en}} {{$hotel->city_name_en}} {{$hotel->province_name_en}}
                        @else
                            {{$hotel->province_name}}{{$hotel->city_name}}{{$hotel->detail}}
                        @endif
                    </span>
                        <a href=""><div class="regular-btn red-btn auto-margin">{{ trans('hotelByCity.view') }}</div></a>
                    </div>
                </div>
            @endforeach
        </div>





    </div>
@stop




@section('script')

    <script >

        $(document).ready(function(){


        })
        var pattern = Trianglify({
            width: $(window).width(),
            height: $(window).height(),
            cell_size: 40});

        document.getElementById('contentSection').appendChild(pattern.canvas());

    </script>
@stop