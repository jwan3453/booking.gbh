@extends('template.layout')

@section('resources')


@stop

@section('content')
    <div id="changeHeader"></div>
    <div id="alertBox" class="alert-box"></div>
    <div id="changeContainer">
        @if(count($errors) > 0)
            <p class="error-alert">修改失败</p>
        @endif
        <div class="change-box">
            <form method="post" action="{{ url('/changePassword') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="trueUser" value="{{ Session::get('changeUser') }}">
                <input type="hidden" name="means" value="{{ Session::get('means') }}">
                <div class="input-pwd">您的用户名 : &nbsp;<input type="text" autocomplete="off" name="username" id="username" placeholder="请输入您的用户名"></div>
                <div class="input-pwd">输入新密码 : &nbsp;<input type="password" autocomplete="off" name="password" id="password" placeholder="请输入新密码"></div>
                <div class="input-pwd">确认新密码 : &nbsp;<input type="password" autocomplete="off" id="pwd" placeholder="请再次输入密码"></div>
                <div class="input-pwd"><button type="submit" id="change-btn">确认</button></div>
            </form>
            <div>
                <a href="/login"><i class="reply icon"></i>返回登录</a>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script>
        $(function(){
            $("#change-btn").click(function(){
                var username = $("#username").val();
                var trueUser = $("#trueUser").val();
                var password = $("#password").val();
                var pwd = $("#pwd").val();
                if(username == ""){
                    toastAlert('请输入用户名',1);
                    return false;
                }
                if(password == ""){
                    toastAlert('请输入密码',1);
                    return false;
                }
                if(pwd == "" ){
                    toastAlert('请再次输入密码',1);
                    return false;
                }

                if(username != trueUser){
                    toastAlert('用户名不符',1);
                    return false;
                }
                if(password != pwd){
                    toastAlert('两次密码不正确',1);
                    return false;
                }
                toastAlert('修改成功,页面即将跳转',1);
            });

        });

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