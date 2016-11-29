@extends('template.layout')

@section('resources')



@stop



@section('content')

    <title>{{ trans('hotelByCategory.title') }}</title>



    <div class="cate-hotel auto-margin">


        <div class="cate-icon">
            <img  src = '{{$hotel['category']->icon}}'>
        </div>
        <div class="cate-name">
            @if(session('lang') == 'en')
                {{$hotel['category']->category_name_en}}
            @else
                {{$hotel['category']->category_name}}
            @endif
            {{trans('hotelByCity.sHotel')}}
            {{--@if(session('lang') == 'en')--}}
                {{--{{$hotel->name_en}}'hotels--}}
            {{--@else--}}

                {{--{{$hotel->name}}酒店--}}
            {{--@endif--}}

        </div>

        <div class="cate-hotel-list auto-margin">
            @foreach($hotel['list'] as $hotel)
            <a href="/hotel/{{$hotel->code}}">
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


                    <div class="text-detail trans_fast  ">

                    <span class="feature">

                        @if(session('lang') == 'en')
                            {{$hotel->hotel_features_en}}
                        @else
                            {{$hotel->hotel_features}}
                        @endif


                    </span>
                    <span class="address"><div class="location-icon" ></div>
                        @if(session('lang') == 'en')
                            {{$hotel->detail_en}} {{$hotel->city_name_en}} {{$hotel->province_name_en}}
                        @else
                            {{$hotel->province_name}}{{$hotel->city_name}}{{$hotel->detail}}
                        @endif
                    </span>
                  <div class="regular-btn red-btn auto-margin">{{ trans('hotelByCategory.view') }}</div>
                </div>
            </div></a>

            @endforeach
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
            height: $(window).height()+257,
            cell_size: 40});

        document.getElementById('contentSection').appendChild(pattern.canvas());

    </script>
@stop