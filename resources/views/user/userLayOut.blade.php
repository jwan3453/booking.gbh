@extends('template.layout')


@section('content')

    {{--<title>用户中心</title>--}}


    <div class="cus-container">
        <div class="user-center">
           <div class="user-center-left">
                <div class="user-icon">
                </div>
                <div class="user-info">
                    <span class="user-name">jwan3453</span>
                    <span class="phone">18250863109</span>
                </div>

               <nav class="user-center-nav">
                   <a href="/user/myorders" class="select-user-nav">我的订单</a>
                   <a href="/user/myaccounts">我的账户</a>
                   <a href="/user/mycollections">我的收藏</a>
                   <a href="/user/message">我的信息</a>
                   <a href="/user/myprofile">我的资料</a>
               </nav>
           </div>

            <div class="user-center-right">
                @yield('user-center-right')
            </div>
        </div>
    </div>

@stop


