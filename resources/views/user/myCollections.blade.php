
@extends('user.userLayout.php')

@section('resources')


@stop



@section('user-center-right')
    <div class="collection-list">

        <div class="h">
            我的酒店搜藏

        </div>


        @foreach($collections as $hotel)
            <a  href="/hotel/{{$hotel->hotelDetail->code}}">


                <div class="c-hotel-box ">

                    <i class="icon empty heart large  " ></i>
                    <img src="{{$hotel->hotelDetail->link}}">


                    <div class="c-hotel-info">
                        <div class="general-info">
                            <span class="name">
                                @if(session('lang') == 'en')
                                    {{$hotel->hotelDetail->name_en}}
                                @else
                                    {{$hotel->hotelDetail->name}}
                                @endif
                            </span>
                            <span class="location">
                                @if(session('lang') == 'en')
                                    {{$hotel->hotelDetail->city_name_en}} , {{$hotel->hotelDetail->province_name_en}}
                                @else
                                    {{$hotel->hotelDetail->province_name}} , {{$hotel->hotelDetail->city_name}}
                                @endif
                            </span>
                        </div>
                        <div class="price">
                            <span class="price-from-text">{{ trans('home.enFrom') }}{{ trans('home.currency') }}</span>{{intval($hotel->hotelDetail->priceFrom)}} <span class="price-from-text">{{ trans('home.zhFrom') }}</span>

                        </div>

                    </div>

                </div>
            </a>
        @endforeach
    </div>
@stop


