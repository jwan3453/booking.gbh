@extends('template.layout')


@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9mVc34VYHPIqmoOCuy7KqWK8NMXtazoY"></script>


@stop

@section('content')
    <title>酒店详情</title>

    {{--<div class="owl-carousel owl-theme hotel-image-cover" id="hotelImageCover">--}}

        {{--@foreach($hotelDetail->coverImageList as $image)--}}
            {{--<div class="slide">--}}
                {{--<img src='{{$image->link}}'>--}}
            {{--</div>--}}
        {{--@endforeach--}}
    {{--</div>--}}


    <div class="hotel-images  ">

        <div class="detail">
            <ul class="hotel-image-list">
                @foreach($hotelDetail->coverImageList as $image)
                    <li >
                        <img src='{{$image->link}}' class="blur">
                        <div class="mask " ></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    <div class="hotel-detail auto-margin">

        <div class="hotel-name">
            @if(session('lang') == 'en')
                {{$hotelDetail->name_en}}
            @else
                {{$hotelDetail->name}}
            @endif

        </div>


        <div class="hotel-desc hotel-line-detail ">
            <div class="ui horizontal divider line-header ">
                {{ trans('hotel.description') }}
            </div>

            <div class="detail">
                @if(session('lang') == 'en')
                    {{$hotelDetail->description_en}}
                @else
                    {{$hotelDetail->description}}
                @endif
            </div>
        </div>

        <div class="hotel-location hotel-line-detail">
            <div class="ui horizontal divider line-header ">
                {{ trans('hotel.location') }}
            </div>
            <div class="detail">
                <span id="hotelAddress">
                    @if(session('lang') == 'en')
                       {{$hotelDetail->address->detail_en}} {{$hotelDetail->city->city_name_en}} {{$hotelDetail->province->province_name_en}}
                    @else
                        {{$hotelDetail->province->province_name}}{{$hotelDetail->city->city_name}}{{$hotelDetail->district_name}}{{$hotelDetail->address->detail}}
                    @endif
                </span>
                <input type=hidden id="addressInCh" value="{{$hotelDetail->province->province_name}}{{$hotelDetail->city->city_name}}{{$hotelDetail->district_name}}{{$hotelDetail->address->detail}}">
                <a id="mapIcon"><div class="map-icon" ></div></a>
            </div>
        </div>


        <div class="hotel-surr hotel-line-detail">

            <div class="ui horizontal divider line-header ">
                {{ trans('hotel.surrounding') }}
            </div>
            <div class="detail " id="surrDetail">
                @foreach($hotelDetail->surroundingList as $surrounding)
                    <div class="surr-item">
                         <span class="name">
                            @if(session('lang') == 'en')
                                {{$surrounding->name_en}}
                            @else
                               {{$surrounding->name}}
                            @endif
                            </span>
                        <span class="distance">  {{ trans('hotel.distance') }}: {{$surrounding->distance}}km</span>
                        <span class="taxi" >  {{ trans('hotel.taxi') }}: {{$surrounding->by_taxi}}  {{ trans('hotel.min') }}</span>
                        <span class="walk">  {{ trans('hotel.walk') }}: {{$surrounding->by_walk}} {{ trans('hotel.min') }}</span>
                        <span class="bus">  {{ trans('hotel.bus') }}: {{$surrounding->by_bus}} {{ trans('hotel.line') }}</span>
                        <input class="nameInZh" type="hidden" value="{{$surrounding->name}}"/>
                    </div>
                @endforeach
            </div>
            <span class="show-all" id="showAllSurr"> {{ trans('hotel.showAll')}}<i class="angle down icon"></i> </span>
        </div>




        @if($hotelDetail->facility != null)

            <div class="hotel-facility hotel-line-detail ">
                <div class="ui horizontal divider line-header ">
                    {{ trans('hotel.facility') }}
                </div>
                <div class="detail" id="facilityList">

                    @foreach($hotelDetail->facility['category'] as $facilityCategory)
                        <div class="facility-list">
                            <div class="category">
                                @if(session('lang') == 'en')
                                    {{$facilityCategory->service_name_en}}
                                @else

                                    {{$facilityCategory->service_name}}
                                @endif
                            </div>
                            <div class="list-items">

                                @foreach($hotelDetail->facility['list'][$facilityCategory->id] as $facilityItem)
                                    <label>
                                        <i class="checkmark box icon"></i>
                                        <span>

                                            @if(session('lang') == 'en')
                                                {{$facilityItem->name_en}}
                                            @else

                                                {{$facilityItem->name}}
                                            @endif
                                        </span>
                                    </label>
                                @endforeach

                            </div>
                        </div>
                    @endforeach

                </div>

                <span class="show-all" id="showAllFaci">{{ trans('hotel.showAll')}} <i class="angle down icon"></i> </span>
            </div>

        @endif

        <div class="hotel-policy hotel-line-detail">
            <div class="ui horizontal divider line-header ">
                {{ trans('hotel.policy') }}
            </div>
            <div class="detail">
                <div class="policy-item">
                    <span class="title"> {{ trans('hotel.checkinOut') }}</span>
                    <span class="de">{{ trans('hotel.checkin')}}: {{$hotelDetail->policy==null?'':$hotelDetail->policy->checkin_time}} , {{ trans('hotel.checkout')}}: {{$hotelDetail->policy==null?'':$hotelDetail->policy->checkout_time}}</span>
                </div>

                {{--<div class="policy-item">--}}
                    {{--<span class="title">证件/押金</span>--}}
                    {{--<span class="de">--}}

                        {{--@if(session('lang') == 'en')--}}
                            {{--{{$hotelDetail->policy->prepaid_deposit_en}}--}}
                        {{--@else--}}

                            {{--{{$hotelDetail->policy->prepaid_deposit}}--}}
                        {{--@endif--}}
                    {{--</span>--}}
                {{--</div>--}}

                <div class="policy-item">
                    <span class="title">{{ trans('hotel.meals')}}</span>
                    <span class="de">

                        @if(session('lang') == 'en')
                            {{$hotelDetail->policy==null?'':$hotelDetail->policy->catering_arrangements_en}}
                        @else

                            {{$hotelDetail->policy==null?'':$hotelDetail->policy->catering_arrangements}}
                        @endif
                    </span>
                </div>


                <div class="policy-item">
                    <span class="title">{{ trans('hotel.other')}}</span>
                    <span class="de">


                        @if(session('lang') == 'en')
                            {{$hotelDetail->policy==null?'':$hotelDetail->policy->other_policy_en}}
                        @else

                            {{$hotelDetail->policy==null?'':$hotelDetail->policy->catering_arrangements}}
                        @endif
                    </span>
                </div>

            </div>

        </div>


        <div class="hotel-rooms hotel-line-detail">
            <div class="ui horizontal divider line-header ">
                {{ trans('hotel.room') }}
            </div>

            @foreach($hotelDetail->rooms as $room )
                <div class="room">

                    <img src="{{count($room->images)>0?$room->images[0]->link.'?imageView/1/w/150/h/150':''}}" />


                    <div class="name">


                        @if(session('lang') == 'en')
                            {{$room->room_name_en}}
                        @else

                            {{$room->room_name}}
                        @endif

                    </div>
                    <div class="description">

                        @if(session('lang') == 'en')
                            {{$room->room_description_en}}
                        @else

                            {{$room->room_description}}
                        @endif
                    </div>



                    <div class="room-price">
                        <span class="m-s">￥</span><span class="price">{{$room->rack_rate}}</span>
                    </div>

                    <div class="booking">
                        <div class="short-btn red-btn auto-margin">{{trans('hotel.bookNow')}}</div>
                    </div>


                </div>
            @endforeach

        </div>


        <iframe src="http://www.google.cn/maps/embed?pb=!1m28!1m12!1m3!1d58102.462678080316!2d118.12116934441082!3d24.471457964990854!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m13!3e0!4m5!1s0x34149a22d926c85b%3A0xcbea272712b05850!2z6KeC6Z-z5bGx5Zu96ZmF5ZWG5Yqh6JCl6L-Q5Lit5b-DOOWPt-alvCDnpo_lu7rnnIHljqbpl6jluILmgJ3mmI7ljLrloZTln5TkuJzot68xNjXlj7c!3m2!1d24.491903!2d118.193856!4m5!1s0x34149b36a642fc1b%3A0x9d977dff7b07a85!2z56aP5bu655yB5Y6m6Zeo5biC5oCd5piO5Yy654Gr6L2m56uZ6I6y5Z2C5ZWG5ZyI5Y-M5ra16Lev5a6Y6YK45aSn5Y6m77yI5YyX6Zeo77yJIOmCruaUv-e8lueggTogMzYxMDA0!3m2!1d24.472618!2d118.118349!5e0!3m2!1szh-CN!2scn!4v1477476217577" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

    </div>





    <div class="hotel-image-gallery" id="hotelImageGallery">

        <div class="gallery-box-wrapper">
            <div class="gallery-box">
                <i class="icon remove circle big" id="closeGallery"></i>



                <div class="gallery-box-left" >
                    <div class="header"></div>
                    <img src="" id="hotelImageShow">
                </div>


                <div class="gallery-box-right">
                    <div class="h-s-l" >
                        <span class="h-s-l-active">{{trans('hotel.all')}}</span>
                        @foreach($hotelDetail->sectionList as $section)
                            <span>{{$section}}</span>
                        @endforeach
                    </div>

                    <div class="h-i-l">



                        <div class='image-list-panel'>
                            @foreach($hotelDetail->sectionList as $section)


                                @foreach($hotelDetail->hotelImageList[$section] as $image)
                                    <div class="h-i-a-l">
                                        <img src='{{$image->link.'?imageView/1/w/135/h/100'}}'>
                                        <span>{{$image->section_name}}</span>
                                    </div>
                                @endforeach
                            @endforeach


                        </div>

                        @foreach($hotelDetail->sectionList as $section)
                            <div class='image-list-panel none-display'>
                                @foreach($hotelDetail->hotelImageList[$section] as $image)
                                    <div class="h-i-a-l">
                                        <img src='{{$image->link.'?imageView/1/w/135/h/100'}}'>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        {{--<div class="padding-80"></div>--}}
                        {{--<div class="padding-80"></div>--}}
                    </div>
                </div>



            </div>
        </div>

    </div>

    <div class="map-box" id="mapBox">
        <i class="icon remove big" id="closeMap"></i>
        <div class="map" id="map"></div>
        <div id="route"></div>
    </div>



@stop


@section('script')

    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop:true,
            responsiveClass:true,
            autoplay:true,
            autoplayTimeout:4000,


            responsive:{
                0:{
                    items:1,

                    loop:true
                },
                600:{
                    items:1,

                    loop:true
                },
                1000:{
                    items:1,

                    loop:true
                }
            }
        })

        $(document).ready(function(){

            var mapLoaded = 0;


            function loadMap() {

                var map = new BMap.Map("map");
                var myGeo = new BMap.Geocoder();
                // 将地址解析结果显示在地图上,并调整地图视野
                myGeo.getPoint($('#addressInCh').val(), function(point){
                    if (point) {
                        map.centerAndZoom(point, 20);
                        var marker = new BMap.Marker(point);  // 创建标注
                        map.addOverlay(marker);               // 将标注添加到地图中
                        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

                        map.enableScrollWheelZoom(true);
                    }else{
                        alert("您选择地址没有解析到结果!");
                    }
                });


            }

            function findPath(surroundingItem){
                var map = new BMap.Map("map");
                var myGeo = new BMap.Geocoder();
                var start = $('#addressInCh').val();
                var end = '{{$hotelDetail->province}}'+'{{$hotelDetail->city}}'+surroundingItem;

                myGeo.getPoint(start, function(point){
                    map.centerAndZoom( point, 12);
                })



                var driving = new BMap.DrivingRoute(map, {renderOptions: {map: map,panel: "route",  autoViewport: true}});
                driving.search(start, end);

            }

            $('#mapIcon').click(function(){
                $('#mapBox').fadeIn();
                if(mapLoaded  === 0) {
                    loadMap();
                    mapLoaded = 1;
                }
            })

            $('#closeMap').click(function(){
                $('#map').empty();
                $('#route').empty();
                $('#mapBox').fadeOut();
            })


            $('.surr-item').click(function(){
                var surroundingItem = $(this).children('.nameInZh').val();
                    findPath(surroundingItem);
                    $('#mapBox').fadeIn();
            })


            $('#showAllSurr').click(function(){
                $('#surrDetail').addClass('auto-height');

            })


            $('#showAllFaci').click(function(){
                $('#facilityList').addClass('auto-height');

            })




            $('.hotel-image-list > li > .mask').click(function(){
                $('#hotelImageGallery').fadeIn(400);
                $('#hotelImageShow').attr('src', $(this).siblings('img').attr('src')+'?imageView/1/w/600/h/400');
            })

            $('.hotel-image-list > li .mask').hover(function(){

                $(this).siblings('img').addClass('hotel-image-list-hover').removeClass('blur');

                },function(){

                $(this).siblings('img').removeClass('hotel-image-list-hover').addClass('blur');

            })


            $('#closeGallery').click(function(){
                $('#hotelImageGallery').fadeOut(400);
            })
//
            $('.h-s-l > span').click(function(){

                $('.h-i-l').children().eq($(this).index()).fadeIn().siblings('div').hide();
                $(this).addClass('h-s-l-active').siblings('span').removeClass('h-s-l-active');
            })
//
            $('.image-list-panel img').click(function(){

                var newLink = $(this).attr('src').substr(0,$(this).attr('src').indexOf('?'));
                $('#hotelImageShow').attr('src', newLink+'?imageView/1/w/600/h/400');

            })

//            var p=0,t=0;
//            var timeout;
//            var scrollSpan =0;
//            $(document).bind("scroll",function() {
//
//                p = $(this).scrollTop();
//
//
//
//
//
//                   // alert(p);
//                    if (t <= p) {
//                        //下滚
//                        scrollSpan = p - t;
//                        var currentTop = $("#hotelImageCover").position().top;
//                        $('#hotelImageCover').animate({top: currentTop + (scrollSpan * 0.5)},5);
//
//
//                    }
//
//                    else {//上滚
//                        scrollSpan = t - p;
//                        var currentTop = $("#hotelImageCover").position().top;
//                        $('#hotelImageCover').animate({top: currentTop - (scrollSpan * 0.5)},5);
//                    }
//
//                    t = p;
//
//            })
        })

    </script>

@stop