@extends('template.layout')


@section('content')

    {{--<title>用户中心</title>--}}


    <div class="cus-container">
        <div class="user-center">
           <div class="user-center-left">
                <div class="user-icon">
                </div>
                <div class="user-info">
                    <span class="user-name">{{$userInfo->username}}</span>
                    <span class="phone">{{$userInfo->phone}}</span>
                </div>

               <nav class="user-center-nav">
                    @if($nav == 'order')
                        <a href="/user/myorders" class="select-user-nav">我的订单</a>
                    @else
                        <a href="/user/myorders">我的订单</a>
                    @endif

                    @if($nav == 'account')
                            <a href="/user/myaccount" class="select-user-nav">我的账户</a>
                    @else
                            <a href="/user/myaccount">我的账户</a>
                    @endif

                    @if($nav == 'collection')
                            <a href="/user/mycollections" class="select-user-nav">我的收藏</a>
                    @else
                            <a href="/user/mycollections">我的收藏</a>
                    @endif

                    @if($nav == 'profile')
                            <a href="/user/myprofile" class="select-user-nav">我的资料</a>
                    @else
                            <a href="/user/myprofile">我的资料</a>
                    @endif

               </nav>
           </div>

            <div class="user-center-right">
                @yield('user-center-right')
            </div>
        </div>
    </div>

@stop


