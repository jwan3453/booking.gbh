@extends('template.layout')

@section('resources')

    <script src="/js/parallax/parallax.min.js"></script>
@stop



@section('content')


    <title>全球精品酒店</title>





    <div class="slogan">
        {{ trans('home.slogan') }}
    </div>
    @if($isMobile)


        <div class="mobile-wrapper" id="mobileCover">
            <img src="booking/img/mobile_cover.jpg">
        </div>


        <div class="mobile-search-bar" id="mobiSearchBar">
            <div class="search-input">
                {{ trans('home.whereToGo') }}
            </div>
            <i class="icon search large"></i>
        </div>


    @else

        <div class="covervid-wrapper" id="vedioCover" >
            <video class="covervid-video scale "   autoplay style="opacity:1"  >
                {{--<source src="videos/clouds.webm" type="video/webm">--}}
                <source src="http://7xw0sv.com1.z0.glb.clouddn.com/view.mp4" type="video/mp4">
            </video>

        </div>


    @endif




        <div class="hotel-search-section scale" id="hotelSearchSection" style="opacity:1">
            <div class="input-with-icon   ">
                <i class="icon marker large"></i>
                <input type="text" placeholder="{{ trans('home.whereToGo') }}" id="destination" data-input=""/>
            </div>
            <div class="home-search-btn  none-space" id="homeSearch"><i class="icon search "></i> </div>
            <i class="cancel-search icon circle remove  big" id="cancelSearch"></i>
        </div>






    <div class="home-sec trans_level_2  "  >

        <div class="header">
            {{ trans('home.selectH') }}
        </div>

        <div class="hotel-rec-list auto-margin " >
            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                         </div>
                        <div class="price">￥990 <span class="q">起</span></div>

                    </div>

                </div>
            </a>

            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                        </div>
                        <div class="price"><span class="q">{{trans('home.from')}}</span> ￥990 <span class="q">{{trans('home.fromZh')}}</span></div>

                    </div>

                </div>
            </a>

            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                        </div>
                        <div class="price">￥990 <span class="q">起</span></div>

                    </div>

                </div>
            </a>

            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                        </div>
                        <div class="price">￥990 <span class="q">起</span></div>

                    </div>

                </div>
            </a>
            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                        </div>
                        <div class="price">￥990 <span class="q">起</span></div>

                    </div>

                </div>
            </a>
            <a  href="">
                <div class="hotel-box ">
                    <div class="cover-image">
                        <img src="booking/img/1.jpg">
                    </div>

                    <div class="h-hotel-info">
                        <div class="general-info">
                            <span class="name">悦泉行管</span>
                            <span class="location"><i class="icon marker"></i>福建,厦门</span>
                        </div>
                        <div class="price">￥990 <span class="q">起</span></div>

                    </div>

                </div>
            </a>

        </div>


    </div>


    <div class="home-sec trans_level_3">
        <div class="header">{{ trans('home.selectC') }}</div>

        <div class="hotel-cate-list auto-margin">




            @foreach($categories as $category)
                <a  href="/category/{{$category->id}}">
                    <div class="hotel-cate">
                        <img src = '{{$category->icon}}'>
                        <span>
                            {{ trans('home.zen') }}

                            @if(session('lang') == 'en')
                                {{$category->category_en}}
                            @else

                                {{$category->category}}
                            @endif

                        </span>
                    </div>
                </a>

            @endforeach

            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/禅.png'>
                    <span>{{ trans('home.zen') }}</span>
                </div>
            </a>

            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/海边.png'>
                    <span>{{ trans('home.Sea') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/蜜月.png'>
                    <span>{{ trans('home.HM') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/人文古厝.png'>
                    <span>{{ trans('home.cultureOldAge') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/森林.png'>
                    <span>{{ trans('home.jungle') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/山水风光.png'>
                    <span>{{ trans('home.landScen') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/设计师之家.png'>
                    <span>{{ trans('home.design') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/饕餮.png'>
                    <span>{{ trans('home.topFood') }}</span>
                </div>
            </a>
            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/温泉.png'>
                    <span>{{ trans('home.spa') }}</span>
                </div>
            </a>

            <a  href="">
                <div class="hotel-cate">
                    <img src = 'booking/icon/乡村回归.png'>
                    <span>{{ trans('home.country') }}</span>
                </div>
            </a>
        </div>
    </div>



    @if(count($hotDestination)>= 7)
        <div class="home-sec white_bg">
        <div class="header">{{ trans('home.hotDestination') }}
        </div>

        <div class="hot-dest-list auto-margin " >



            @for($i = 0; $i<4; $i++)


                <a  href="/hotelByCity/{{$hotDestination[$i]->code}}">
                    <div class="dest-box-t ">
                        <div class="cover-image">
                            <img src="{{$hotDestination[$i]->cover_image}}"/>
                        </div>

                        <div class="dest-box-mask trans_slow">
                            <span>
                                @if(session('lang') == 'en')
                                    {{$hotDestination[$i]->city_name_en}}
                                @else

                                    {{$hotDestination[$i]->city_name}}
                                @endif
                            </span>
                            <div class="fly-icon auto-margin i-icon" ></div>
                        </div>

                    </div>
                </a>

            @endfor



        </div>

        <div class="hot-dest-list auto-margin " >

            @for($i = 4; $i<count($hotDestination); $i++)



                <a  href="/hotelByCity/{{$hotDestination[$i]->code}}">
                    <div class="dest-box-f ">
                        <div class="cover-image">
                            <img src="{{$hotDestination[$i]->cover_image}}"/>
                        </div>

                        <div class="dest-box-mask trans_slow">
                            <span>
                                @if(session('lang') == 'en')
                                    {{$hotDestination[$i]->city_name_en}}
                                @else

                                    {{$hotDestination[$i]->city_name}}
                                @endif
                            </span>
                            <div class="fly-icon auto-margin i-icon" ></div>
                        </div>

                    </div>
                </a>

            @endfor


        </div>




    </div>
    @endif


    <div class="parallax-window" data-z-index="100" data-parallax="scroll" data-image-src="booking/img/bg_comment.jpg" >
        <div class="parra-left">
            <div class="up">我们正全力为您挑选全国各地的精品酒店</div>
            <div class="down">目前数量有限，但是我们会加快脚步，收集全国的精品酒店</div>
        </div>

        <div class="parra-right">
            <div class="thumb">
                <img src="booking/img/ceo.png">
            </div>
            <div class="description">
                <div class="up">CEO: Ben Foo</div>
                <div class="down">一直都在寻找精品酒店的路上</div>
            </div>
        </div>
    </div>

@stop


@section('script')

    <script >


        if($(window).width()<=767)
        {
            $('#vedioCover').empty();

        }

        $.fn.getCityDestinations = function(optionFiled)
        {

            var inputObj = $(this);
            var cityHotelList ;
            var $container ;
            var $searchContainer ;

            //ajax 获取数据
            $.ajax({
                type: 'POST',
                url: '/getDestinationCitiesHotels',
                dataType: 'json',
                async:false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data){
                    if(data.statusCode === 1)
                    {
                        cityHotelList = data.extra;

                        //创建城市列表html
                        $container = setupContainer();
                        $searchContainer = setupSearchContainer();

                        var offset = inputObj.offset();
                        var height = inputObj.height();
                        var width = inputObj.width();
                        var cont_top = offset.top + height;
                        var cont_left = offset.left;

                        var selectedProvince='';
                        var selectedProvinceId = 0;

                        var selectedCity ='';
                        var selectedCityId =0

                        var selectedDistrict='';
                        var selectedDistrictId = 0;

                        //设置contianer 基本css
                        $container.appendTo($("body")).css({
                            'color': '#505050',
                            'position':'absolute',
                            'display':'none',
                            'background':' #f8f8f8',

                            'font':'13px',
                            'z-index':'100'
                        });

                        @if($isMobile)

                            $container.appendTo($("body")).css({
                                'top': 50,
                                'left': 0,
                                'width':'100%'}
                            );
//                            $container.attr('id','searchContainerWrapper');
                        @else
                            $container.appendTo($("body")).css({
                            'top': cont_top+3,
                            'left': cont_left-37,
                            'width':480}
                        );

                        @endif

                        $searchContainer.css('display','none');// = 'none';


                    }
                    else{

                    }
                }
            })

            $('#destination').keyup(function(){

                searchDestin();
            })

            //for ios
            $('#destination').on('input paste', function() {
                searchDestin();
            });




            //搜索城市
            function searchDestin()
            {

                var offset = inputObj.offset();
                var height = inputObj.height();
                var width = inputObj.width();
                var cont_top = offset.top + height;
                var cont_left = offset.left;
                var inputField = inputObj;
                if(inputField.val()!== '')
                {
//                    $container.fadeOut();
                    $searchContainer.appendTo($("body")).css({

                        'color': '#505050',
                        'position':'absolute',
                        'display':'none',
                        'background':' white',
                        'border':'1px solid grey',
                        'font':'13px',
                        'z-index':'100'
                    })



                    @if($isMobile)

                        $searchContainer.appendTo($("body")).css({
                        'top': 50,
                        'max-height':200,
                        'width':'100%',
                        'overflow-y':'scroll'
                    });
//                            $container.attr('id','searchContainerWrapper');
                    @else
                        $searchContainer.appendTo($("body")).css({
                        'top': cont_top ,
                        'left': cont_left-38,
                        'width':478,
                        'max-height':200,
                        'overflow-y':'scroll'
                    });

                    @endif

                    $searchContainer.empty();
                    var searchListCount = 0;
//                    $.each(cityHotelList, function(key,cities)
//                    {

                    var domesticCityList = cityHotelList['domestic'];
                    var internationalCityList  = cityHotelList['international'];
                    var hotelList = cityHotelList['hotel'];

                    //查找国内城市
                    $.each(domesticCityList, function(key,cities)
                    {

                        searchCity(cities,key,'ds');
                    })

                    //查找国外城市
                    $.each(internationalCityList, function(key,cities)
                    {
                        searchCity(cities,key,'int');
                    })


                    //查找酒店
                    $.each(hotelList, function(key,hotel)
                    {
                        var hotelName='';
                        @if(session('lang') == 'en')
                            hotelName = hotel.name_en;
                        @else
                            hotelName =hotel.name;
                        @endif

                        if(hotelName!=null && (hotelName.toLowerCase()).indexOf($.trim(inputObj.val().toLowerCase())) !== -1)
                        {


                            var html = '<a href="/hotel/'+hotel.code+'"><div class="geo-search-line">' +
                                    '<i class ="icon hotel  large"></i>' +
                                    '<span class="c" id="'+ hotel.code +'">'+hotelName+'</span>' +
                                    '</div></a>';
                            $searchContainer.show();

                            $searchContainer.append(html);
                        }


                    })



                }
            }


            //搜索城市
            function searchCity(cities,key,area)
            {
                if(cities.length > 0 && key !== 'hotDestination')
                {
                    for(var i=0; i<cities.length; i++)
                    {

                        var cityName='';
                        @if(session('lang') == 'en')
                            cityName = cities[i].city_name_en;
                        @else
                            cityName =cities[i].city_name;
                        @endif

                        if(cityName!=null && (cityName.toLowerCase()).indexOf($.trim(inputObj.val().toLowerCase())) !== -1)
                        {


                            var html = '<a href="/hotelByCity/'+area+'/'+cities[i].code+'"><div class="geo-search-line">' +
                                    '<i class ="icon marker large"></i>' +
                                    '<span class="c" id="'+ cities[i].code +'">'+cityName+'</span>' +
                                    '</div></a>';
                            $searchContainer.show();

                            $searchContainer.append(html);
                        }
                    }
                }
            }

            //动态填充城市名
            function fillCityHtml(initialList, citySection)
            {

                var html = '';
                var numOfCityByInitial = 0;
                initialList.forEach(function(initial)
                {
                    if( typeof(cityHotelList['domestic'][initial]) !== 'undefined')
                    {
                        html += '<div class=city_group>';
                        if(initial !== 'hotDestination')
                            html += '<div class="city-initial">'+initial+'</div>';

                        html += '<div class=city-initial-list>';


                        cityHotelList['domestic'][initial].forEach(function(city){
                            var cityName = '';
                            @if(session('lang') == 'en')
                                cityName = city.city_name_en;
                            @else
                                cityName = city.city_name;
                            @endif
                            html += '<span id="city_' + city.code + '">'+cityName+'</span>'
                            numOfCityByInitial++;
                        })
                        html +='</div></div>';
                    }

                })
                if(numOfCityByInitial == 0 )
                    citySection.append('<span>'+"{{trans('home.noCities')}}"+'</span>');

                citySection.append(html);
            }

            function setupContainer(){

                var container = document.createElement("div");
                var areaOption =document.createElement('div');



                var domestic = document.createElement('div');
                var dCaption = document.createElement("div");
                var hotDestination = document.createElement("div");
                var city_a_e = document.createElement("div");
                var city_f_j = document.createElement('div');
                var city_k_p = document.createElement('div');
                var city_q_v = document.createElement('div');
                var city_w_z = document.createElement('div');


                var $container = $(container).attr("id", "container");
                var $areaOption =$(areaOption).attr("id", "areaOption").addClass('area-option');

                var $domestic = $(domestic).attr('id','domestic').addClass('domestic-cities');
                var $dCaption = $(dCaption).attr("id", "dCaption").addClass('d-caption-section');
                var $hotDestination = $(hotDestination).attr("id", "hotDestination");
                var $city_a_e = $(city_a_e).attr("id", "city_a_e");
                var $city_f_j = $(city_f_j).attr("id", "city_f_j");
                var $city_k_p = $(city_k_p).attr("id", "city_k_p");
                var $city_q_v = $(city_q_v).attr("id", "city_q_v");
                var $city_w_z = $(city_w_z).attr("id", "city_w_z");


                var domesText = '';
                var intText = '';
                var hotText = '';
                @if(session('lang') == 'en')
                    domesText = 'China';
                    intText = 'International';
                    hotText = 'Hot'
                @else
                    domesText = '国内';
                    intText = '国际';
                    hotText = '热门';
                @endif

                var areaOptionHtml = '<span class="current-select" id="ds">' +domesText+ '</span>' +
                                     '<span id="int">'+intText+'</span>';
                $areaOption.append(areaOptionHtml);

                var captionHtml = '<span id="cap_ds_hot" class=" d-caption">'+hotText+'</span>'+
                        '<span  class="active d-caption"  id="cap_a_e">ABCDE</span>'+
                        '<span  id="cap_f_j" class=" d-caption">FGHIJ</span>'+
                        '<span  id="cap_k_p" class=" d-caption">KLMNOP</span>'+
                        '<span  id="cap_q_v" class=" d-caption">QRSTUV</span>'+
                        '<span id="cap_w_z"  class=" d-caption">WXYZ</span>';
                $dCaption.append(captionHtml);
                $domestic.append($dCaption).append($hotDestination).append($city_a_e).append($city_f_j).append($city_k_p).append($city_q_v).append($city_w_z);

                $hotDestination.addClass('city-section');
                $city_a_e.addClass("city-section");
                $city_f_j.addClass("city-section");
                $city_k_p.addClass("city-section");
                $city_q_v.addClass("city-section");
                $city_w_z.addClass("city-section");



                //填充国内city 的html
                var initial_list = [];

                initial_list = ['hotDestination'];
                fillCityHtml(initial_list,$hotDestination);

                initial_list = ['A','B','C','D','E'];
                fillCityHtml(initial_list,$city_a_e);

                initial_list = ['F','G','H','I','J'];
                fillCityHtml(initial_list,$city_f_j);


                initial_list = ['K','L','M','N','O','P']
                fillCityHtml(initial_list,$city_k_p);


                initial_list = ['Q','R','S','T','U','V'];
                fillCityHtml(initial_list,$city_q_v);


                initial_list = ['W','X','Y','Z'];
                fillCityHtml(initial_list,$city_w_z);

                //最初默认城市列表为 A 到 D 的城市
                $city_a_e.show();




                //国际城市区域
                var international = document.createElement('div');
                var iCaption = document.createElement("div");

                var $international = $(international).attr('id','international').addClass('international-cities');
                var $iCaption= $(iCaption).attr("id", "iCaption").addClass('i-caption-section');

                captionHtml = '';
                var interCityHtml = '';

                captionHtml += '<span  class=" i-caption" id="cap_int_hot">'+hotText+'</span>';



                //添加热门城市
                interCityHtml += '<div  class="city-section" id="'+ 'hot_int_city">';
                cityHotelList['international']['hotDestination'].forEach(function(city)
                {
                    var cityName = '';
                    @if(session('lang') === 'en')
                        cityName = city.city_name_en;
                    @else
                        cityName = city.city_name;
                    @endif
                    interCityHtml += '<span id="city_' + city.code + '">'+cityName+'</span>';
                })
                interCityHtml +='</div></div>';


                cityHotelList['international']['continentList'].forEach(function(continent){

                    var  continentIndex = continent['name_en'];

                    //默认显示亚洲城市
                    if(continentIndex == 'Asia')
                    {
                        interCityHtml += '<div  style="display:block" class="city-section" id="'+continentIndex +'_city">';
                    }
                    else{
                        interCityHtml += '<div  class="city-section" id="'+continentIndex +'_city">';
                    }

                    interCityHtml += '<div class="city-initial-list"> ';
                    cityHotelList['international'][continentIndex].forEach(function(city)
                    {
                                var cityName = '';
                                @if(session('lang') === 'en')
                                    cityName = city.city_name_en;
                                @else
                                    cityName = city.city_name;
                                @endif
                                interCityHtml += '<span id="city_' + city.code + '">'+cityName+'</span>';
                    })

                    if(cityHotelList['international'][continentIndex].length==0)
                    {
                        interCityHtml += '<span>'+"{{trans('home.noCities')}}"+'</span>';
                    }

                    interCityHtml +='</div></div>';

                    //默认显示亚洲城市(caption)
                    var contientName = '';
                    @if(session('lang') === 'en')
                        contientName = continent['name_en'];
                    @else
                        contientName = continent['name'];
                    @endif
                if(continentIndex == 'Asia')
                    {
                        captionHtml += '<span  class="active i-caption" id="'+continent['name_en']+'">'+contientName+'</span>';
                    }
                    else{
                        captionHtml += '<span class="i-caption"  id="'+continent['name_en']+'">'+contientName+'</span>';
                    }




                })
                //把所有的html 拼接回container
                $iCaption.append(captionHtml);
                $international.append($iCaption);
                $international.append(interCityHtml);


                $container.append($areaOption).append($domestic).append($international);


                return $container;
            }

            function setupSearchContainer(){
                var searchContainer = document.createElement("div");
                var $searchContainer = $(searchContainer).attr("id", "searchContainer");
                return $searchContainer;
            }
            function showContainer(){
                if($container.css('display') === 'none')//
                {

                    if($searchContainer.css('display') ==='none' ) {


                        setTimeout(function () {
                            $container.fadeIn(100);
                        }, 100);

                    }
                }
            }


            //点击切换国内 国外城市
            var selectedArea = 'ds';//默认国内区域
            $(document).on('click','#areaOption span', function(){
                $(this).addClass('current-select').siblings('span').removeClass('current-select');
                if($(this).attr('id') == 'ds')
                {
                    selectedArea = 'ds';
                    $('#domestic').show();
                    $('#international').hide();
                }
                else{
                    selectedArea = 'int';
                    $('#domestic').hide();
                    $('#international').show();
                }

            })

            //点击字母分类切换国内城市
            $(document).on('click','.d-caption',function(){


                $(this).addClass('active').siblings('span').removeClass('active');
                if($(this).attr('id')==='cap_ds_hot')
                {
                    $('#hotDestination').show().siblings('.city-section').hide();
                }
                if($(this).attr('id')==='cap_a_e')
                {
                    $('#city_a_e').show().siblings('.city-section').hide();
                }
                if($(this).attr('id')==='cap_f_j')
                {

                    $('#city_f_j').show().siblings('.city-section').hide();
                }
                if($(this).attr('id')==='cap_k_p')
                {
                    $('#city_k_p').show().siblings('.city-section').hide();
                }
                if($(this).attr('id')==='cap_q_v')
                {
                    $('#city_q_v').show().siblings('.city-section').hide();
                }
                if($(this).attr('id')==='cap_w_z')
                {
                    $('#city_w_z').show().siblings('.city-section').hide();
                }

            })

            //点击大洲切换国际城市
            $(document).on('click','.i-caption',function(){
                $(this).addClass('active').siblings('span').removeClass('active');

                if($(this).attr('id')==='cap_int_hot')
                {
                    $('#hot_int_city').show().siblings('.city-section').hide();
                }
                else{
                    $('#'+$(this).attr('id')+'_city').show().siblings('.city-section').hide();
                }
            })

            //选择国内城市
            $(document).on('click','.city-initial-list > span, #hot_int_city>span',function() {

                 @if($isMobile)
                        location.href ='/hotelByCity/'+selectedArea+'/'+$(this).attr('id').split('_')[1];
                 @else
                        location.href ='/hotelByCity/'+selectedArea+'/'+$(this).attr('id').split('_')[1];
                        //$('#destination').attr('data-input',$(this).attr('id').split('_')[1]).val($(this).text());
                        $('#container').hide();
                 @endif

            })




            //选择搜索出来的城市
            $(document).on('click','.geo-search-line',function(){
                @if($isMobile)
                    location.href ='/hotelByCity/'+$(this).find('span').attr('id');
                @else
                    $('#destination').attr('data-input',$(this).find('span').attr('id')).val($(this).text());
                    $('#container').hide();
                @endif

           })

            //点击搜索酒店
            $('#homeSearch').click(function(){
                location.href ='/search/'+$('#destination').val();
            })

//            $(document).on('click','.city',function(){
//
//                districtSection.empty();
//                districtSection.hide();
//
//                selectedCityId = $(this).attr('id').split('_')[1];
//                selectedCity = $(this).text();
//
//                $(this).addClass('geo-selected ').siblings('span').removeClass('geo-selected ');
//
//                for(var i=0; i<districtList.length; i++) {
//
//                    if (parseInt(selectedCityId) === parseInt(districtList[i].city_code)) {
//
//                        $('<span class="district" ' +
//                                'id="district_' + districtList[i].code + "_" + selectedCityId + "_" + selectedProvinceId +'\">' +
//                                $.trim(districtList[i].district_name) + '</span>').appendTo(districtSection);
//                    }
//                }
//
//                provinceSection.hide();
//                citySection.hide();
//                districtSection.slideToggle();
//
//                $('#cap_d').addClass('active').siblings('span').removeClass('active');
//
//
//            });



            $(document).on('click','.geo-search-line',function(){



                $('#province').val($.trim($(this).find('.p').text())+' - '
                        +$.trim($(this).find('.c').text()) + ' - '
                        +$.trim($(this).find('.d').text()) );
                $('#provinceCode').val($.trim($(this).find('.p').attr('id')));


                $('#cityCode').val($.trim($(this).find('.c').attr('id')));


                $('#district').val($.trim($(this).find('.d').attr('id')));

                $searchContainer.hide();

            })


            $(document).bind("click",function(e){

                //点击隐藏城市列表
                e = e || window.event;
                var target = $(e.target);
                if(target.closest($container).length == 0 &&target.closest($('#hotelSearchSection')).length == 0 && target.closest($('#province')).length == 0){
                    if($container.css('display') !== 'none')
                    {

                        $container.hide ();
                    }
                }
                if(target.closest($searchContainer).length == 0){
                    if($searchContainer.css('display') !== 'none')
                    {

                        $searchContainer.hide ();
                    }
                }


            });

            $(this).focus(function(){
                showContainer();
            });
            optionFiled.click(function(){
                showContainer();
            });

        }

        $(document).ready(function(fn){

            //各种上翻的效果(模糊,缩放)
            var p=0,t=0;
            var timeout;
            var scrollSpan =0;
            var initalScroll = 0;
            var blurValue= 0,scaleValuex=1,scaleValuey=1,scaleValuez=1;
            var opacityValue =1;
            $(document).bind("scroll",function(){

                clearTimeout(timeout);
                timeout = setTimeout(function() {

                    p = $(this).scrollTop();



                    if(p <= 500)
                    {
                        if (t <= p) {
                            //下滚
                            scrollSpan = p-t;
                            blurValue = blurValue + (scrollSpan*0.03);

                            scaleValuex=scaleValuex+(scrollSpan * 0.0005);
                            scaleValuey= scaleValuey+(scrollSpan * 0.0005);
                            var scale = scaleValuex+ ','+scaleValuey+','+scaleValuez;
                            opacityValue = opacityValue - (scrollSpan * 0.005);

                            //视频变模糊
                            $('#vedioCover').css('-webkit-filter','blur('+blurValue +'px)');
                            //视屏放大效果
                            $('#vedioCover').css('transform','translate3d(0px, 0px, 0px) scale3d('+scale+')');

                            //视频变模糊
                            $('#mobileCover').css('-webkit-filter','blur('+blurValue +'px)');
                            //视屏放大效果
                            $('#mobileCover').css('transform','translate3d(0px, 0px, 0px) scale3d('+scale+')');

                            //$('#hotelSearchSection').css('opacity',opacityValue).css('-webkit-filter','blur('+blurValue +'px)');


                        }

                        else {//上滚
                            scrollSpan = t-p;
                            blurValue = blurValue - (scrollSpan*0.03);

                            scaleValuex=scaleValuex-(scrollSpan * 0.0005);
                            scaleValuey= scaleValuey-(scrollSpan * 0.0005);
                            var scale = scaleValuex+ ','+scaleValuey+','+scaleValuez;
                            opacityValue = opacityValue + (scrollSpan * 0.005);
                            $('#vedioCover').css('-webkit-filter','blur('+blurValue +'px)');
                            $('#vedioCover').css('transform','translate3d(0px, 0px, 0px) scale3d('+scale+')');

                            $('#mobileCover').css('-webkit-filter','blur('+blurValue +'px)');
                            $('#mobileCover').css('transform','translate3d(0px, 0px, 0px) scale3d('+scale+')');

                           // $('#hotelSearchSection').css('opacity',opacityValue).css('-webkit-filter','blur('+blurValue +'px)');
                        }

                        setTimeout(function () {
                            t = p;
                        }, 0);
                    }

                }, 10);
            })

            //parallax effect
            $('.parallax-window').parallax();

            //城市列表插件
            $('#destination').getCityDestinations($('#mobiSearchBar'));

            $('#mobiSearchBar').click(function(){

               $('#container').css('display','block');
               $('#hotelSearchSection').fadeIn();
            })
            $('#cancelSearch').click(function(){
                $('#hotelSearchSection').fadeOut();
                $('#container').fadeOut();
            })

            $('.dest-box-mask').hover(function() {

                        var obj = $(this);

                        obj.addClass('bright-bg');
                        obj.find('span').stop().animate({top: -150}, 400, function () {
                            $(this).fadeOut(100);
                        })
                        obj.find('.i-icon').show().stop().animate({top: -100}, 400);

                },
                function(){

                    var obj = $(this);
                    obj.children().stop(false,true);
                    obj.removeClass('bright-bg');
                    obj.find('span').stop().show().animate({top: 0},400);
                    $(this).find('.i-icon').stop().animate({top: 100},400,function(){
                        $(this).fadeOut(100);
                    });
            })

        })

    </script>

@stop

