
<!DOCTYPEhtml>
<html>
<head>
    <meta charset="utf-8">
    <title>请登录-全球精品酒店</title>
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="keywords" content="GBH，gbhchina，,全球精品酒店，精品酒店预定,globalBotiqueHotel，精品酒店">
    <meta name="description" content="全球精品酒店，全球精品酒店平台。在gbh，寻找中国乃至世界上独一无二的精品酒店">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" type="image/x-icon" href="http://og9duuhyy.bkt.clouddn.com/logo/gbhchina_log.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <link rel="stylesheet" type="text/css" href={{ asset('booking/css/style.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>


    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <script src={{ asset('semantic/modal.min.js') }}></script>
    <script src={{ asset('js/jquery.form.js') }}></script>
    @yield('resources')

</head>
<body>
<div id="containerLogin">
    <div id="contentSection">
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

    </div>
    @yield('content')
</div>
</body>
@yield('script')
<script>
    $(function(){
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
        );
        $('.nav-toggle').click(function () {
            $('body').toggleClass('nav-open');
        });



    });
</script>
</html>
