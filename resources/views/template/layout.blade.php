
<!DOCTYPEhtml>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="keywords" content="GBH，gbhchina，,全球精品酒店，精品酒店预定,globalBotiqueHotel，精品酒店">
    <meta name="description" content="全球精品酒店，全球精品酒店平台。在gbh，寻找中国乃至世界上独一无二的精品酒店">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" type="image/x-icon" href="http://og9duuhyy.bkt.clouddn.com/logo/gbhchina_log.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>



    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('booking/css/style.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/popup.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/divider.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/flag.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('booking/css/css3nav/styles.css') }}>--}}
    <link  rel="stylesheet" type="text/css"  href ={{ asset('booking/css/styles.min.css') }}>

    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    {{--<script src={{ asset('semantic/transition.min.js') }}></script>--}}
    {{--<script src={{ asset('semantic/popup.min.js') }}></script>--}}
    {{--<script src={{ asset('semantic/dropdown.min.js') }}></script>--}}
    {{--<script src="/js/parallax/parallax.min.js"></script>--}}
    {{--<script src="/js/triang.min.js"></script>--}}
    <script src={{ asset('booking/js/all.min.js') }}></script>
    @yield('resources')

</head>

<body id="body">

    <div style="position:relative" id="contentSection">
        <div class="site-header  ">

            <div class="logo">
            </div>

            <div class="switch-lang">
                <div class="select-lang">

                    @if(session('lang')=='zh_cn')

                        <i class="cn flag "></i>
                        <span>简体中文</span>
                    @else
                        <i class="gb flag "></i>
                        <span>English</span>
                    @endif
                        <i class="angle down icon"></i>
                </div>
                <div class="lang-list">
                    <a href="/lang/zh_cn"><div class="lang">
                        <i class="cn flag "></i>
                        <span>简体中文</span>

                    </div></a>
                    <a href="/lang/en"><div class="lang">
                        <i class="gb flag "></i>
                        <span>English</span>

                    </div></a>
                </div>
            </div>



            <div class="site-menu-nav">

                <div>
                    <a  href="/">
                        <span>{{ trans('home.home') }}</span>
                    </a>

                    <a href="/destinationList">
                        <span>{{ trans('home.hotD') }}</span>
                    </a>

                    <a href="http://www.gbhchina.com/aboutUs">
                        <span>{{ trans('home.aboutUs') }}</span>
                    </a>


                </div>

            </div>




            <div class="nav-toggle">
                <div class="icon"></div>
            </div>

        </div>


        @yield('content')
    </div>


    @yield('extra')




    <div class="footer-box ">

        <ul class="footer-ul auto-margin">

            <li class="social-link">
                <img src ='/booking/icon/wechat.png' class="footer-icon " id="webchatIcon"   data-html=''  />
                <img src ='/booking/icon/weibo.png' class="footer-icon" id="weiboIcon"   data-html=''  />
                <div class="qr-image" id="qrImage">
                    <img src = "/booking/img/wechat_qr.jpg" style="width:160px; height:160px;">
                    <span style="font-size:14px; display: block;width: 100%; text-align: center">微信扫一扫关注</span>
                </div>
            </li>


            <li>
                <span>{{ trans('home.aboutUs') }}</span>
                <a href="http://www.gbhchina.com/aboutUs">{{ trans('home.aboutGbh') }}</a>
                <a href="http://www.gbhchina.com/contactUs">{{ trans('home.contactUs') }}</a>
                <a href="http://www.gbhchina.com/newArticles">{{ trans('home.articles') }}</a>
            </li>
            <li>
                <span>{{ trans('home.aboutTeam') }}</span>
                <a href="http://www.gbhchina.com/team">{{ trans('home.team') }}</a>
                <a href="http://www.gbhchina.com/joinUs">{{ trans('home.joinUs') }}</a>
            </li>

            <li>
                <span>{{ trans('home.bookingEmail') }}</span>
                <a>booking@gbhchina.com</a>
            </li>

            <li>
                <span>{{ trans('home.customerService') }}</span>
                <a>0592-5657031</a>
            </li>




        </ul>
        <div class="copy-right auto-margin">

            <span class="up"> {{ trans('home.copyRightUp') }}</span>
            <span class="down"> {{ trans('home.copyRightDown') }}</span>

        </div>
        <div class="statistic">
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259646848'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1259646848%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
        </div>
    </div>


</body>







@yield('script')

<script type="text/javascript">

    $(document).ready(function(){



        //语言选择
        $('.switch-lang').hover(

            function(){

                $('.lang-list').fadeIn();
            },
            function(){
                var event = window.event ||arguments.callee.caller.arguments[0];;
                if($('.lang-list').closest(event.srcElement).length <= 0)
                {
                    $('.lang-list').fadeOut();
                }
            }
         )


        $('.nav-toggle').click(function () {
            $('body').toggleClass('nav-open');
        });

//        $('#webchatIcon').attr('data-html', $('.qr-image').html())
//                .popup({
//
//                    lastResort: 'right center'
//
//                })


        $('#webchatIcon').hover(function () {
                    $(this).attr('src', '/booking/icon/wechat_green.png');
                    t = setTimeout(function() {
                        $('#qrImage').fadeIn();
                    },200);
                },
                function () {
                    $(this).attr('src', '/booking/icon/wechat.png');
                    $('#qrImage').fadeOut();
                    clearTimeout(t);
                })

        $('#weiboIcon').hover(function(){
                    $(this).attr('src', '/booking/icon/weibo_red.png');
                },
                function () {
                    $(this).attr('src', '/booking/icon/weibo.png');
                })


        var timeout;
        var p=0;
        $(document).bind("scroll",function(){

            clearTimeout(timeout);
            timeout = setTimeout(function() {

                p = $(this).scrollTop();

                if(p !=0 && !$('.site-header').hasClass('site-header-scrollTop'))
                {
                    $('.site-header').addClass('site-header-scrollTop');
                }
                if(p === 0)
                {
                    $('.site-header').removeClass('site-header-scrollTop');
                }
            }, 50);
        })
    })


</script>

</html>
