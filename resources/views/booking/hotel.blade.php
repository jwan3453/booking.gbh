@extends('template.layout')


@section('resources')
    {{--<script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>--}}
    {{--<link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>--}}
    {{--<link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>--}}
    @if( $hotelDetail->address->type =='1')

    {{--<script id="baiduMapAPI" type="text/javascript" src="http://api.map.baidu.com/api?v=quick&ak=9mVc34VYHPIqmoOCuy7KqWK8NMXtazoY"></script>--}}
    <script src="http://webapi.amap.com/maps?v=1.3&key=c782c3fe3c22c1d753fb40d7ef09eb49"></script>
    @else
    <script src="http://ditu.google.cn/maps/api/js?sensor=true&key=AIzaSyBVbzDkqtNh-dK916AMJMsrF3G1BtUpHwg"></script>
    @endif

    <script  type="text/javascript" src= {{ asset('js/calendar.js')}}></script>
@stop

@section('content')
    <title>
        @if(session('lang') == 'en')
            {{$hotelDetail->name_en}}
        @else
            {{$hotelDetail->name}}
        @endif
    </title>

    @include('partial.calender')
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


    <div class="hotel-header" id="hotelHeader">
        <div class="hotel-name">
            @if(session('lang') == 'en')
                {{$hotelDetail->name_en}}
            @else
                {{$hotelDetail->name}}
            @endif
        </div>


        <div class="image-count">
            ({{trans('hotel.total')}}{{$hotelDetail->imageCount}}{{trans('hotel.image')}})
        </div>
    </div>

    {{--<div class="date-search-bar" >--}}
        {{--<div>--}}
            {{----}}
        {{--</div>--}}
    {{--</div>--}}


    <div class="hotel-detail-wrap">

        <div class="hotel-detail auto-margin">

            <form class="search-date-box-wrap" id="searchRoomDateForm">

                <input type="hidden" name="hotelId" value="{{$hotelDetail->id}}" />
                <div class="search-date-box" id="searchDateBox">
                    <input class="check-in-date date-input" name="checkInDate" id="checkInDate" type="text" placeholder="入住日期"  readonly/>
                    <input class="check-out-date date-input" name="checkOutDate" id="checkOutDate" type="text" placeholder="离店日期" readonly/>
                </div>


                <div class="search-room-btn" id="searchRoomBtn">
                    <span>搜索房间</span>
                    <div class="ui active loader search-room-loader" id="searchRoomLoader"></div>
                </div>


                <div class="hotel-collection">
                    <div>
                        @if($hotelDetail->collection == 0)
                            <i class="icon empty heart big add" id="addCollection"></i>
                            <span>收藏</span>
                         @else
                            <i class="icon empty heart big remove" id="addCollection"></i>
                            <span>取消收藏</span>
                        @endif
                    </div>
                </div>

            </form>

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
                           {{$hotelDetail->address->detail_en}} {{$hotelDetail->city->city_name_en}} {{$hotelDetail->province->province_name_en}}{{$hotelDetail->province->name_en}}
                        @else
                            {{$hotelDetail->province->name}}{{$hotelDetail->province->province_name}}{{$hotelDetail->city->city_name}}{{$hotelDetail->district=''?$hotelDetail->district->district_name:'' }}{{$hotelDetail->address->detail}}

                        @endif
                    </span>
                    <input type=hidden id="addressInCh" value="{{$hotelDetail->province->province_name}}{{$hotelDetail->city->city_name}}{{$hotelDetail->district=''?$hotelDetail->district->district_name:'' }}{{$hotelDetail->address->detail}}">
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
                            @if(trim($surrounding->by_bus)!== '')
                                <span class="bus">  {{ trans('hotel.bus') }}: {{$surrounding->by_bus}} {{ trans('hotel.line') }}</span>
                            @endif
                            <input class="nameInZh"   type="hidden" value="{{$surrounding->name}}"/>
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


                        <div class="facility-list">
                            <div class="category">

                                <div class="catering-icon service-icon"></div>
                                <span>{{ trans('hotel.catering') }}</span>
                            </div>

                            <div  class="list-detail" >
                                @foreach($hotelDetail->cateringList as $cateringItem)
                                <div class="list-items">
                                    <label>

                                            <span>
                                                @if(session('lang') == 'en')
                                                    {{$cateringItem->name_en}}
                                                @else

                                                    {{$cateringItem->name}}
                                                @endif
                                            </span>
                                    </label>

                                    <label>

                                        <span>
                                            {{ trans('hotel.businessHour') }}: {{$cateringItem-> business_hour}}
                                        </span>

                                    </label>
                                </div>
                                @endforeach
                            </div>

                        </div>


                        {{--<div class="facility-list">--}}
                            {{--<div class="category">--}}
                                {{--{{ trans('hotel.recreation') }}--}}
                            {{--</div>--}}

                            {{--<div  class="list-detail" >--}}
                                {{--@foreach($hotelDetail->recreationList as $recreationItem)--}}
                                    {{--<div class="list-items">--}}
                                        {{--<label>--}}

                                            {{--<span>--}}
                                                {{--@if(session('lang') == 'en')--}}
                                                    {{--{{$recreationItem->name_en}}--}}
                                                {{--@else--}}

                                                    {{--{{$recreationItem->name}}--}}
                                                {{--@endif--}}
                                            {{--</span>--}}
                                        {{--</label>--}}

                                        {{--<label>--}}

                                        {{--<span>--}}
                                            {{--{{ trans('hotel.businessHour') }}: {{$recreationItem-> business_hour}}--}}
                                        {{--</span>--}}

                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}

                        {{--</div>--}}


                        @foreach($hotelDetail->facility['category'] as $facilityCategory)
                            <div class="facility-list">
                                <div class="category">

                                    @if($facilityCategory->service_type == 1)
                                        <div class="general-service-icon service-icon"></div>
                                    @elseif($facilityCategory->service_type == 2)
                                        <div class="recreation-icon service-icon"></div>
                                    @elseif($facilityCategory->service_type == 3)
                                        <div class="general-facility-icon service-icon"></div>
                                    @elseif($facilityCategory->service_type == 4)
                                        <div class="room-facility-icon service-icon"></div>
                                    @endif

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
                        <span class="title">{{ trans('hotel.airportTransfer')}}</span>
                        <span class="de">

                            @if(session('lang') == 'en')
                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->airport_transfer_en}}
                            @else

                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->airport_transfer}}
                            @endif
                        </span>
                    </div>

                    <div class="policy-item">
                        <span class="title">{{ trans('hotel.petPolicy')}}</span>
                        <span class="de">
                            @if(session('lang') == 'en')
                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->pet_policy}}
                            @else
                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->pet_policy_en}}
                            @endif
                        </span>
                    </div>


                    <div class="policy-item">
                        <span class="title">{{ trans('hotel.other')}}</span>
                        <span class="de">

                            @if(session('lang') == 'en')
                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->other_policy_en}}
                            @else

                                {{$hotelDetail->policy==null?'':$hotelDetail->policy->other_policy_en}}
                            @endif
                        </span>
                    </div>



                    <div class="policy-item">
                        <span class="title">{{ trans('hotel.payPolicy')}}</span>
                        <div class="de">
                            {{--@if(session('lang') == 'en')--}}
                                {{--{{$hotelDetail->policy==null?'':$hotelDetail->policy->pay_policy}}--}}
                            {{--@else--}}
                                {{--{{$hotelDetail->policy==null?'':$hotelDetail->policy->pet_policy_en}}--}}
                            {{--@endif--}}
                            @if(strpos($hotelDetail->policy->pay_policy,'m')!== false)
                                <div class="master-card pay-icon" >
                                    <div class="tooltip">
                                        <div class="triangle-up"></div>
                                        <div class="text">{{trans('hotel.visaCard')}}</div>
                                    </div>
                                </div>
                            @endif
                            @if(strpos($hotelDetail->policy->pay_policy,'v')!== false)
                                <div class="visa-card pay-icon">
                                    <div class="tooltip">
                                        <div class="triangle-up"></div>
                                        <div class="text"> {{trans('hotel.visaCard')}}</div>
                                    </div>
                                </div>
                            @endif
                            @if(strpos($hotelDetail->policy->pay_policy,'u')!== false)
                                <div class="unionPay pay-icon">
                                    <div class="tooltip">
                                        <div class="triangle-up"></div>
                                        <div class="text"> {{trans('hotel.unionPay')}}</div>
                                    </div>
                                </div>
                            @endif
                            @if(strpos($hotelDetail->policy->pay_policy,'a')!== false)
                                <div class="aliPay pay-icon">
                                    <div class="tooltip">
                                        <div class="triangle-up"></div>
                                        <div class="text"> {{trans('hotel.aliPay')}}</div>
                                    </div>
                                </div>
                            @endif
                            @if(strpos($hotelDetail->policy->pay_policy,'w')!== false)
                                <div class="wechatPay pay-icon">
                                    <div class="tooltip">
                                        <div class="triangle-up"></div>
                                        <div class="text"> {{trans('hotel.wechatPay')}}</div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>


                </div>

            </div>


            <div class="hotel-rooms hotel-line-detail" id="roomList">
                <div class="ui horizontal divider line-header ">
                    {{ trans('hotel.room') }}
                </div>

                <?php $roomIndex=0;?>
                @foreach($hotelDetail->rooms as $room )
                    <div class="room"  data-index="{{$roomIndex}}" id="room_{{$room->id}}">

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
                            <span class="m-s">{{ trans('home.currency') }}</span><span class="price">{{$room->rack_rate}}</span>
                        </div>


                        <div class="booking">
                            <div href="/newOrder/{{$hotelDetail->id}}/{{$room->id}}/" class="short-btn red-btn auto-margin">{{trans('hotel.bookNow')}}</div>
                        </div>


                    </div>
                    <?php $roomIndex++;?>
                @endforeach


                <div class="no-room-aval" id="noRoomAval">


                </div>

            </div>






    </div>

    </div>




    <div class="room-detail-gallery" id="roomDetailGalleryBox">
        <div class="room-detail-box-wrapper">

            <div class="room-gallery-box" id="galleryBox">
                <i class="icon remove circle big" id="closeRoomBox"></i>

                <div class="room-gallery-box-left" id="roomGalleryBoxLeft" >


                </div>



                <div class="room-gallery-box-right" id="roomGalleryBoxRight">
                    <div class="room-attributes-list">
                        <div class="room-attribute">
                            <span class="attr-name"><i class="icon user"></i>{{trans('hotel.numOfPeople')}}</span><span id="numOfPeople"></span>
                        </div>
                        <div class="room-attribute">
                            <span class="attr-name"><i class="icon food"></i>{{trans('hotel.numOfBreakfast')}}</span><span id="numOfBreakfast"></span>
                        </div>
                        <div class="room-attribute">
                            <span class="attr-name"><i class="icon grid layout icon"></i>{{trans('hotel.acreage')}} </span><span id="acreage"></span>
                        </div>
                        <div class="room-attribute">
                            <span class="attr-name"><i class="hotel icon"></i>{{trans('hotel.bedSize')}} </span><span id="bedSize"></span>
                        </div>
                        <div class="room-attribute">
                            <span class="attr-name"><i class="icon wifi"></i>{{trans('hotel.wifi')}} </span><span id="wifi"></span>
                        </div>
                        <div class="room-attribute">
                            <span class="attr-name"><i class="plus icon"></i>{{trans('hotel.extraBed')}}</span><span id="extraBed"></span>
                        </div>

                        <div class="room-attribute">
                            <span class="attr-name"><i class="map pin icon"></i>{{trans('hotel.locationInfo')}}</span><span id="locationInfo"></span>
                        </div>

                        <div class="room-attribute">
                            <span class="attr-name"><i class="info circle icon"></i>{{trans('hotel.otherInfo')}}</span><span id="otherInfo"></span>
                        </div>

                        <div>
                    </div>
                </div>

            </div>
        </div>
        </div>
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
//        $('.owl-carousel').owlCarousel({
//            loop:true,
//            responsiveClass:true,
//            autoplay:true,
//            autoplayTimeout:4000,
//
//
//            responsive:{
//                0:{
//                    items:1,
//
//                    loop:true
//                },
//                600:{
//                    items:1,
//
//                    loop:true
//                },
//                1000:{
//                    items:1,
//
//                    loop:true
//                }
//            }
//        })

        function loadMap() {

            @if( $hotelDetail->address->type =='1')

                var map = new AMap.Map('map',{
                    resizeEnable: true
                });

                //map.setLang('zh_en');
                AMap.service(["AMap.PlaceSearch"], function() {
                var placeSearch = new AMap.PlaceSearch({ //构造地点查询类
                    pageSize: 1,
                    pageIndex: 1,
                    city: "010", //城市
                    map: map//,
                    //panel: "panel"
                });
                //关键字查询
                placeSearch.search($('#addressInCh').val()+'{{$hotelDetail->name}}', function(status, result) {
                });
            });

//                var map = new BMap.Map("map");
//                var myGeo = new BMap.Geocoder();
//                // 将地址解析结果显示在地图上,并调整地图视野
//                myGeo.getPoint($('#addressInCh').val(), function(point){
//                    if (point) {
//                        map.centerAndZoom(point, 20);
//                        var marker = new BMap.Marker(point);  // 创建标注
//                        map.addOverlay(marker);               // 将标注添加到地图中
//                        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
//
//                        map.enableScrollWheelZoom(true);
//                    }else{
//                    alert("您选择地址没有解析到结果!");
//                }
//            });
//
            @else
                var geocoder;
                geocoder = new google.maps.Geocoder();

                var mapOptions = {
                    zoom: 16
                }
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                google.maps.event.trigger(map, 'resize');
                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                codeAddress();

                function codeAddress() {
                    var address = $('#addressInCh').val();
                    geocoder.geocode( { 'address': address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location
                            });
                        } else {
                            console.log("Geocode was not successful for the following reason: " + status);
                        }
                    });
                }
            @endif
        }

        var loadOnce = false;
        function findPath(surroundingItem){

            @if( $hotelDetail->address->type =='1')

                {{--$('#map').html('');--}}
                {{--var map = new BMap.Map("map");--}}
                {{--var myGeo = new BMap.Geocoder();--}}
                {{--var start = $('#addressInCh').val();--}}
                {{--var end ='{{$hotelDetail->province->province_name}}'+'{{$hotelDetail->city->city_name}}'+surroundingItem;--}}

{{--//                    map.clearOverlays();--}}
{{--//                    myGeo.getPoint(start, function(point){--}}
{{--//                        map.centerAndZoom( point, 12);--}}
{{--//                    })--}}
{{--//                    var driving = new BMap.DrivingRoute(map, {renderOptions: {map: map,panel: "route",  autoViewport: true}});--}}
{{--//                     driving.search(start, end);--}}
                {{--map.clearOverlays();--}}
                {{--search(start,end,'BMAP_DRIVING_POLICY_LEAST_TIME');--}}
                {{--function search(start,end,route){--}}
                    {{--var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true},policy: route});--}}
                    {{--driving.search(start,end);--}}
                {{--}--}}
                var map = new AMap.Map('map',{
                        resizeEnable: true
                    });
                map.setLang('zh_en');
                AMap.service('AMap.Driving',function(){//回调函数
                //实例化Driving
                var driving= new AMap.Driving({
                    map:map,
                    city: "{{$hotelDetail->city->city_name}}"//城市，默认：“全国”
                });

                var start = $('#addressInCh').val()+'{{$hotelDetail->name}}';
                var end ='{{$hotelDetail->province->province_name}}'+'{{$hotelDetail->city->city_name}}'+surroundingItem;

                driving.search([{keyword:start},{keyword:end}], function(status, result) {
                    //TODO 解析返回结果，自己生成操作界面和地图展示界面
                });
                //TODO: 使用driving对象调用驾车路径规划相关的功能
            })



            @else


                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                google.maps.event.trigger(map, 'resize');
                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                directionsDisplay.setMap(map);
                directionsDisplay.setPanel(document.getElementById("directionsPanel"));
                var start = $('#addressInCh').val();

                var end ='{{$hotelDetail->province->province_name}}'+'{{$hotelDetail->city->city_name}}'+surroundingItem;

                var request = {
                    origin:start,
                    destination:end,
                    travelMode: google.maps.TravelMode.DRIVING
                };
                directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    }
                });
            @endif
        }





        $(document).ready(function(){


            //添加hotel header特效
            $('.hotel-images').hover(

                function(){
                    $('#hotelHeader').addClass('hotel-header-animate');
                },
                function(){
                    $('#hotelHeader').removeClass('hotel-header-animate');

            })


            @if( $hotelDetail->address->type =='1')


           @else

                var mapLoaded = 0;
                var directionsDisplay;
                var directionsService = new google.maps.DirectionsService();
                var map;
                directionsDisplay = new google.maps.DirectionsRenderer();
                var china = new google.maps.LatLng(39.8563912573, 116.4027431763);
                var mapOptions = {
                    zoom:7,
                    center: china
                }
            @endif




            $('#mapIcon').click(function(){

                $('#mapBox').fadeIn();
                loadMap();


            })

            $('#closeMap').click(function(){
//                $('#map').empty();
                $('#route').empty();
                $('#mapBox').fadeOut();
            })


            $('.surr-item').click(function(){
                $('#mapBox').fadeIn();
                var surroundingItem = $(this).children('.nameInZh').val();

                    findPath(surroundingItem);

            })


            $('#showAllSurr').click(function(){

                if($('#surrDetail').hasClass('auto-height'))
                {
                    $('#surrDetail').removeClass('auto-height');
                }
                else
                {
                    $('#surrDetail').addClass('auto-height');
                }
            })


            $('#showAllFaci').click(function(){

                if($('#facilityList').hasClass('auto-height'))
                {
                    $('#facilityList').removeClass('auto-height');
                }
                else
                {
                    $('#facilityList').addClass('auto-height');
                }

            })



            //显示支付名称
            $('.pay-icon').hover(function(){

                $(this).find('.tooltip').show();
            },function(){
                $(this).find('.tooltip').hide();
            })

            //把room 明细转成javascript array
            var currentRoomNavIndex = 0;
            var imageCount = 0;
            var re = new RegExp("&quot;", 'g');
            var roomDetail = '{{$hotelDetail->roomsInJson}}'.replace(re,'"');
            roomDetail = JSON.parse(roomDetail);
            $('.room > .name, .room > img').click(function(){



                $('#currentImage').text(1);

                var roomIndex=$(this).parent('div').attr('data-index');
                var roomName = '';

                @if(session('lang') == 'en')
                    roomName = roomDetail[roomIndex].room_name_en;
                @else
                    roomName = roomDetail[roomIndex].room_name;
                @endif

                var htmlLeft = '<div >';

                htmlLeft += '<div class="room-name">'+ roomName+'</div>';
                htmlLeft += '<div style="position:relative"><img  class="show-image" id="roomImageShow" src="'+roomDetail[roomIndex].images[0].link +'">';
                htmlLeft += '<div class="room-image-pager" id="roomImagePager">'+
                                '<span id="currentImage">1'+
                                    '</span>'+
                                    '/'+
                                    '<span id="totalImage">'+
                                '</span>'+
                            '</div>';
                htmlLeft += '<i class=" big arrow circle left icon image-nav-left"></i>'+
                        '<i class="big arrow circle right icon image-nav-right"></i>'+
                        '</div><div class="room-image-nav">';

                var selectedClass  =  'room-image-nav-select';
                imageCount = roomDetail[roomIndex].images.length;

                for(var i = 0; i<roomDetail[roomIndex].images.length; i++)
                {

                    if(i != 0 )
                    {
                        selectedClass = '';
                    }
                    htmlLeft += '<img  class="'+selectedClass+'" src="'+roomDetail[roomIndex].images[i].link+'?imageView/1/w/135/h/100' +'">';
                }

                htmlLeft += '</div></div>';

                //动态加载左边图像
                $('#roomGalleryBoxLeft').empty().append(htmlLeft);


                $('#totalImage').text(imageCount);
                //加载房间属性
                $('#numOfPeople').text(roomDetail[roomIndex].num_of_people);
                $('#numOfBreakfast').text(roomDetail[roomIndex].num_of_breakfast );
                $('#acreage').text(roomDetail[roomIndex].acreage + 'm²');
                $('#bedSize').text(roomDetail[roomIndex].bed.length + 'm x '+ roomDetail[roomIndex].bed.width +'m');
                var wifi;
                if(roomDetail[roomIndex].wifi == 0)
                {
                    wifi = '{{trans('hotel.noWifi')}}';
                }
                else if(roomDetail[roomIndex].wifi == 1)
                {
                    wifi = '{{trans('hotel.wifiWithCharge')}}';
                }
                else{
                    wifi = '{{trans('hotel.freeWifi')}}';
                }
                $('#wifi').text(wifi);

                var extraBed = '';
                if(roomDetail[roomIndex].is_extra_bed == 0)
                {
                    extraBed = '{{trans('hotel.noExtraBed')}}';
                }
                else if(roomDetail[roomIndex].is_extra_bed == 1)
                {
                    extraBed = '{{trans('hotel.extraBedWithCharge')}}';
                }
                else{
                    extraBed = '{{trans('hotel.freeExtraBed')}}';
                }

                $('#extraBed').text(extraBed);

                var locationInfo = '';
                var otherInfo='';
                @if(session('lang') == 'en')
                    locationInfo = roomDetail[roomIndex].location_info_en;
                    other_info = roomDetail[roomIndex].other_info_en;
                @else
                    locationInfo = roomDetail[roomIndex].location_info;
                    other_info = roomDetail[roomIndex].other_info;
                @endif

                $('#locationInfo').text(locationInfo);
                $('#otherInfo').text(other_info);

                $('#roomDetailGalleryBox').fadeIn(100);
            })




            $('#closeRoomBox').click(function(){
                $('#roomDetailGalleryBox').fadeOut(100);
            })

            //点击酒店图片画廊图片
            $('.hotel-image-list > li > .mask').click(function(){


                $('#hotelImageGallery').show();
                $('#hotelImageShow').attr('src', $(this).siblings('img').attr('src')+'?imageView/1/w/600/h/400');
            })

            //hover 显示酒店图片
            $('.hotel-image-list > li .mask').hover(function(){

                $(this).siblings('img').addClass('hotel-image-list-hover').removeClass('blur');

                },function(){

                $(this).siblings('img').removeClass('hotel-image-list-hover').addClass('blur');

            })


            $('#closeGallery').click(function(){
                $('#hotelImageGallery').fadeOut(400);
            })
            //酒店图片区域导航
            $('.h-s-l > span').click(function(){

                $('.h-i-l').children().eq($(this).index()).fadeIn().siblings('div').hide();
                $(this).addClass('h-s-l-active').siblings('span').removeClass('h-s-l-active');
            })
//
            $('.image-list-panel img').click(function(){

                var newLink = $(this).attr('src').substr(0,$(this).attr('src').indexOf('?'));
                $('#hotelImageShow').attr('src', newLink+'?imageView/1/w/600/h/400');

            })


            //房间图片左右导航
            $(document).on('click','.image-nav-left ',function(){

                if(currentRoomNavIndex <= imageCount  && currentRoomNavIndex >= 1)
                {
                    currentRoomNavIndex--;
                    $(".room-image-nav > img:eq("+currentRoomNavIndex+")").click();
                    $('#currentImage').text(currentRoomNavIndex+1);
                }
            })

            $(document).on('click','.image-nav-right ',function(){
                if(currentRoomNavIndex < imageCount -1 )
                {
                    currentRoomNavIndex++;
                    $(".room-image-nav > img:eq("+currentRoomNavIndex+")").click();
                    $('#currentImage').text(currentRoomNavIndex+1);
                }
            })

            $(document).on('click','.room-image-nav > img',function(){

                currentRoomNavIndex = $(this).index();
                $('#currentImage').text(currentRoomNavIndex+1);

                $(this).addClass('room-image-nav-select').siblings('img').removeClass('room-image-nav-select');

                var newLink = $(this).attr('src').substr(0,$(this).attr('src').indexOf('?'));
                $('#roomImageShow').attr('src', newLink+'?imageView/1/w/600/h/400');

            })


            //收藏酒店
            var collection = '{{$hotelDetail->collection}}';
            $('#addCollection').click(function(){


            if(parseInt(collection) ==0)

                $.ajax({
                    type: 'POST',
                    url: '/addtocollection',
                    dataType: 'json',
                    data:{hotel:'{{$hotelDetail->code}}'},
                    async:false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            toastAlert('收藏成功',data.statusCode);
                            collection = 1;
                            $('#addCollection').removeClass('add').addClass('remove').siblings('span').text('取消收藏');

                        }
                        else{
                            toastAlert('收藏失败',data.statusCode);
                        }

                    },
                    error:function(){
                    }
                })
            else{
                $.ajax({
                    type: 'POST',
                    url: '/removefromcollection',
                    dataType: 'json',
                    data:{hotel:'{{$hotelDetail->code}}'},
                    async:false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            toastAlert('取消成功',data.statusCode);
                            collection = 0;

                            $('#addCollection').removeClass('remove').addClass('add').siblings('span').text('收藏');;
                        }
                        else{
                            toastAlert('取消失败',data.statusCode);
                        }

                    },
                    error:function(){
                    }
                })
            }



            })


            //选择日期
            $('#checkInDate').showCalendar($('#checkOutDate'));


            //点击关闭日历
            $(document).bind("click",function(e){

                //点击隐藏日历

                e = e || window.event;
                var target = $(e.target);
                var test = target.parents();

                if((target.closest($('#calendar')).length == 0 &&target.closest($('#searchDateBox')).length == 0) &&target.closest($('.refine-date')).length == 0 && target.parents().length !==0){


                    $('#calendar').hide();
                }

            });

            //搜索框锁定
            var timeout;
            $(window).scroll(function() {

                clearTimeout(timeout);
                timeout = setTimeout(function() {

                    if($(this).scrollTop()> 450)
                    {
                        $('.search-date-box-wrap').css('left',$('.search-date-box-wrap').offset().left).addClass('search-date-box-wrap-fixed');
                        $('.calendar').css('left',$('.calendar').offset().left).addClass('calendar-fixed');
                    }
                    else{
                        $('.search-date-box-wrap').removeClass('search-date-box-wrap-fixed').removeAttr('style');
                        $('.calendar').removeClass('calendar-fixed')
                    }


                }, 10);

            });

            //点击房间搜索ajax
            $('#searchRoomBtn').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/searchRoomByDate',
                    dataType: 'json',
                    data: $('#searchRoomDateForm').serialize(),
                    async:false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){
                        $('#searchRoomLoader').transition('fade');
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            $('html, body').animate({scrollTop:$('#roomList').offset().top-60}, 'fast');
                            //房态列表, 删去无房的房间
                            var roomStatus =data.extra;
                            for(var i=0; i<roomStatus['nonAvlRoomId'].length;i++)
                            {
                                   $('#room_'+roomStatus['nonAvlRoomId'][i]).hide();
                            }

                            //恢复空房房型
                            for(var i=0; i<roomStatus['avlRoomList'].length;i++)
                            {
                                $('#room_'+roomStatus['avlRoomList'][i].id).show().find('.price').text(roomStatus['avlRoomList'][i].avgPrice).transition('jiggle');

                            }


                            if(roomStatus['avlRoomList'].length == 0)
                            {

                                var html = '';
                                if(roomStatus['nonPublished'] == false)
                                {
                                    html = '<span class="reason">所选时间没有空余房型,</span>'+
                                            '<span>您可以<span>更改 <span class="refine-date">入住/离店</span> 时间</span>, 或者重新<a href="/" class="research-hotel">搜索酒店</a></span>';
                                    $('#noRoomAval').empty().append(html).show();

                                }
                                else{
                                    html = '<span class="reason">酒店房价尚未公布,</span>'+
                                            '<span>您可以<span>更改 <span class="refine-date">入住/离店</span> 时间</span>, 或者重新<a href="/" class="research-hotel">搜索酒店</a></span>';
                                    $('#noRoomAval').empty().append(html).show();;

                                }
                            }
                            else{
                                $('#noRoomAval').hide();
                            }


                        }
                        else{

                        }
                        $('#searchRoomLoader').transition('fade');

                    },
                    error:function(){
                        $('#searchRoomLoader').transition('fade');

                    }
                })
            })

            //点击重新搜索日期
            $(document).on('click','.refine-date', function() {
                $('#checkInDate').click();
            });

            //
            $('.booking').click(function(){

                var href  = $(this).find('div').attr('href');
                location.href = href+$('#checkInDate').val()+'/'+$('#checkOutDate').val();
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