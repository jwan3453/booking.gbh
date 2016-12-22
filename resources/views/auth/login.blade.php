
@extends('auth.index')

@section('resources')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.6/semantic.min.css"/>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.6/semantic.min.js"></script>
@stop

@section('content')
    <div class="login-box">
        <div class="login-body">
            <span class="top-logo"></span>
            <p>欢迎登录-全球精品酒店</p>
            <hr>
            <div id="alertBox" class="alert-box"></div>
            <form method="post" action="#">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(count($errors) > 0)
                    {{--<p class="error-alert">用户名或密码不正确</p>--}}
                    {{--<input type="hidden" id="error" value="{{$error}}">--}}
                @endif
                @if(Cookie::has('username'))
                    <div class="input-box">
                        <span class="user-icon"></span>
                        <input type="text" name="username" id="username" autocomplete="off" placeholder="请输入您的用户名" value="{{$username}}">
                    </div>
                @elseif(!Cookie::has('username'))
                    <div class="input-box">
                        <span class="user-icon"></span>
                        <input type="text" name="username" id="username" autocomplete="off" placeholder="请输入您的用户名">
                    </div>
                @endif


                <div class="input-box">
                    <span class="pwd-icon"></span>
                    <input type="password" name="password" id="password" autocomplete="off" placeholder="请输入您的密码">
                </div>
                <div class="choice-box">
                    <label><input type="checkbox" name="remember" checked>记住我</label>

                    <div class="forgot-pwd" data-toggle="modal" data-target="#modal-rewrite">
                        <a href="#" id="forgot">忘记密码?</a>
                    </div>
                </div>
                <div class="btn-box">
                    <div id="subbtn">登录</div>
                    <a href="/register">注册</a>
                </div>
            </form>
            <div class="copy-footer">

                <span class="up">全球精品酒店 版权所有 2016-2028 保留所有权利 </span>
                <span class="down"> All rights reserved. 闽ICP备16016886号</span>

            </div>
        </div>
    </div>

{{--弹窗层--}}
    <div class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            忘记密码
        </div>
        <div id="tableChoice">
            <ul>
                <li id="byEmail" class="choice-table">通过邮箱找回</li>
                <li id="bymobile">通过手机找回</li>
            </ul>
        </div>
        <div class="content email-verify">
            <div class="send-message">
                <form method="post" action="">

                    {{--<input type="hidden" name="_method" value="PUT">--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="log-user" id="logUser" placeholder="请输入您的用户名" style="width: 315px; margin-top: -20px;">
                    <input type="text" name="email" id="email" placeholder="请输入您的邮箱" style="width: 315px;">

                    <div class="send-btn"><div id="emailBtn" class="btn-pwd">确认发送</div></div>
                </form>
            </div>

        </div>
        <div class="content mobile-verify">
            <div class="send-message by-mobile">
                <form method="post" action="">
                    {{--<input type="hidden" name="_method" value="PUT">--}}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="sendCode">
                        <input type="text" name="mobile" id="mobile" placeholder="请输入手机号">
                        <span class="sms-code" id="smsCode">发送验证码</span>
                    </div>
                    <input type="text" name="code" id="code" placeholder="请输入验证码" class="write-code" style="width: 315px;">

                    <div class="send-btn"><div id="mobileBtn" class="btn-pwd">确认发送</div></div>
                </form>
            </div>

        </div>
    </div>


@stop
@section('script')


<script>
    $(function(){

        //登录
        $("#subbtn").click(function(){
            var username = $("#username").val();
            var password = $("#password").val();
            if(username == ""){
                toastAlert('请输入用户名',1);
                return false;
            }
            if(password == ""){
                toastAlert('请输入密码',1);
                return false;
            }


            //登录验证
            $.ajax({
                type:'POST',
                async:false,
                url:'/login',
                data:{username:username,password:password},
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data == 1){
                        toastAlert('用户名不存在',1);
                        return false;

                    }
                    if(data == 3){
                        toastAlert('密码不正确',1);
                        return false;
                    }
                    window.location.href = '/';
                }
            });



        });

        //弹窗按钮
        $("#forgot").click(function(){

            $('.basic.test.modal')
                    .modal('setting', 'closable', true)
                    .modal('show')
            ;

            $('.ui.modal')
                    .modal({
                        blurring: true
                    })
                    .modal('show')
            ;
        });

        //方式切换
        $("#bymobile").click(function(){
            $(this).removeClass('table-null').addClass('choice-table');
            $("#byEmail").removeClass('choice-table').addClass('table-null');
            $(".mobile-verify").removeClass('choice-null').addClass('choice-verify');
            $(".email-verify").removeClass('choice-verify').addClass('choice-null');

        });
        $("#byEmail").click(function(){
            $(this).removeClass('table-null').addClass('choice-table');
            $("#bymobile").removeClass('choice-table').addClass('table-null');
            $(".email-verify").removeClass('choice-null').addClass('choice-verify');
            $(".mobile-verify").removeClass('choice-verify').addClass('choice-null');

        });


        //忘记密码验证

        //发送验证码
        $("#smsCode").click(function(){

            var sendBtn = $(this);

            if($("#mobile").val()==""){
                toastAlert('手机号不能为空',1);
                $("#mobile").focus();
                return false;
            }

            $.ajax({
                type:'POST',
                async:false,
                url:'/checkMobile',
                data:{mobile:$.trim($('#mobile').val()),type:1},
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data==1){
                        //验证码发送成功
                        $.ajax({
                            type:'POST',
                            async:false,
                            url:'/sendCode',
                            data:{mobile:$.trim($('#mobile').val()),type:1},
                            dataType:'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            success:function(data){
                                if(data==1){
                                    //验证码发送成功
                                    settime(sendBtn);
                                    $('input[name="mobile"]').show();
                                }else{
                                    sendBtn.text('发送验证码');
                                }
                            },
                            error:function(){
                                toastAlert('错误:请输入注册时的手机号码',1);
                            }
                        });
                    }else{
                        toastAlert('错误:请输入注册时的手机号码',1);
                    }
                },
                error:function(){
                    toastAlert('错误:请输入注册时的手机号码',1);
                }
            });


        });

        //通过手机验证
        $("#mobileBtn").click(function(){


            var mobile = $("#mobile").val();
            var code = $("#code").val();
            if(mobile == "" || code == ""){
                toastAlert('还有信息尚未填写',1);
                return false;
            }
            //验证码
            $.ajax({
                type:'POST',
                async:false,
                url:'/checkCode',
                data:{mobile:mobile,code:code},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data==1){


                        $.ajax({
                            type:'POST',
                            async:false,
                            url:'/searchMobile',
                            data:{mobile:mobile},
                            dataType:'json',
                            headers:{
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            success:function(data){
                                if(data==1){
                                    toastAlert('验证成功,即将跳转页面',1);
                                    $("#mobileBtn").html('正在提交&nbsp;<div class="ui active inline loader"></div>');

                                    function jumBack(){
                                        window.location.href = '/mobileBlade';
                                    }

                                    setTimeout(jumBack,2000);
                                }else {
                                    toastAlert('发送失败',1);
                                    return false;
                                }
                            },
                            error:function(){
                                toastAlert('发送失败',1);
                                return false;
                            }
                        });

                    }else{
                        toastAlert('验证码错误',1);
                        return false;
                    }
                },
                error:function(){
                    toastAlert('验证码错误',1);
                    return false;
                }
            });
        });

        //通过邮箱验证
        $("#emailBtn").click(function(){

            var username = $("#logUser").val();
            var email = $("#email").val();
            var code = $("#code").val();
            var pregEmail = /\w[-\.\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,14}/;
            if(email == "" || username == ""){
                toastAlert('还有信息尚未填写',1);
                return false;
            }
            if(!pregEmail.test(email)){
                toastAlert('邮箱格式不正确',1);
                return false;
            }
            //验证用户名
            $.ajax({
                type:'POST',
                async:false,
                url:'/checkUser',
                data:{username:username},
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data == 1){

                        //验证邮箱
                        $.ajax({
                            type:'POST',
                            async:false,
                            url:'/checkEmail',
                            data:{email:email},
                            dataType:'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            success:function(data){
                                if(data == 1){

                                    $("#emailBtn").html('正在提交&nbsp;<div class="ui active inline loader"></div>');

                                    //验证码发送成功则可用发送邮件
                                    $.ajax({
                                        type:'POST',
                                        async:false,
                                        url:'/auth/sendMessage',
                                        data:{email:email,username:username},
                                        dataType:'json',
                                        headers:{
                                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        },
                                        success:function(data){
                                            if(data==1){
                                                toastAlert('发送成功,您将会收到确认邮件',1);

                                                function jumBack(){
                                                    window.location.href = '/auth/login';  //提交方式是GET,注意路由方式不要写错
                                                }

                                                setTimeout(jumBack,2000);
                                            }else {
                                                toastAlert('发送失败',1);
                                                return false;
                                            }
                                        },
                                        error:function(){
                                            toastAlert('发送失败',1);
                                            return false;
                                        }

                                    });

                                }else {
                                    toastAlert('请输入注册时的邮箱',1);
                                    return false;
                                }
                            }
                        });

                    }else {
                        toastAlert('用户名不存在',1);
                        return false;
                    }
                }
            });


        });

    });

    //验证码倒计时
    var countdown=60;//倒计时60秒
    function settime(obj) {


        if (countdown == 0) {

//                obj.removeClass('code-send');
            obj.text("再次发送");
            countdown = 60;
            return;
        } else {
            obj.addClass('code-wait');
            obj.addClass('changeBack');
            obj.text(countdown+'秒后可重发' );
            obj.attr('disabled','disabled');
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
    //信息提示框
    function toastAlert(Msg,status)
    {

        if(status === 1)
        {
            $('#alertBox').removeClass('wrong-input').addClass('wrong-input');
        }
        $('#alertBox').text(Msg).fadeIn();

        setTimeout(function () {
            $('#alertBox').fadeOut();
        }, 2000);

    }
</script>
@stop
