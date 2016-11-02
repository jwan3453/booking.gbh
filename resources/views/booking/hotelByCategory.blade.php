@extends('template.layout')

@section('resources')

    <script src="/js/parallax/parallax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.4.0/trianglify.min.js"></script>

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
            <div class="cate-hotel-detail">
                <div class="cover-image">
                    <img class="trans_fast" src="{{$hotel->link}}">
                    <div >
                        <h2>

                            @if(session('lang') == 'en')
                                {{$hotel->name_en}}
                            @else

                                {{$hotel->name}}
                            @endif
                        </h2>
                        <p>￥12299 <span>{{ trans('hotelByCategory.from') }}</span></p>
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
                    <a href="/hotel/{{$hotel->id}}"><div class="regular-btn red-btn auto-margin">{{ trans('hotelByCategory.view') }}</div></a>
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