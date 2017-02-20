
@extends('auth.index')

@section('content')
    <div class="register-box">
        <div id="alertBox" class="alert-box"></div>
        <div class="alert-loading">
            <h2>正在提交<i class="spinner icon"></i></h2>
        </div>
        <div class="register-body">
            <span class="top-logo"></span>
            <p>欢迎注册-全球精品酒店</p>
            <hr>

            <form method="post" action="{{url('/auth/register')}}" id="regForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @if(count($errors) > 0)
                    <p class="error-alert">邮箱或手机号已注册过</p>
                @endif
                <div class="input-collections">
                    <ul>
                        <li class="input-list">
                            <i class="user icon"></i>
                            <input type="text" name="user[username]" autocomplete="off" placeholder="请设置用户名" id="username">
                            <i class="remove icon username-error-icon"></i>
                            <i class="checkmark icon username-success-icon"></i>
                        </li>
                        <li class="input-list input-left-style">
                            <i class="mail icon"></i>
                            <input type="text" name="user[email]" autocomplete="off" placeholder="请输入您的邮箱地址" id="email">
                            <i class="remove icon email-error-icon"></i>
                            <i class="checkmark icon email-success-icon"></i>
                        </li>
                        <li class="input-list input-top-style">
                            <i class="lock icon"></i>
                            <input type="password" name="user[password]" autocomplete="off" placeholder="请设置您的密码" id="password">
                            <i class="remove icon password-error-icon"></i>
                            <i class="checkmark icon password-success-icon"></i>
                        </li>
                        <li class="input-list input-left-style">
                            <i class="lock icon"></i>
                            <input type="password" placeholder="请再次输入您的密码" id="pwd" >
                            <i class="remove icon pwd-error-icon"></i>
                            <i class="checkmark icon pwd-success-icon"></i>
                        </li>
                        <li class="input-list input-top-style input-list-mobile">
                            <i class="call icon"></i>
                            <input type="text" name="user[phone]" autocomplete="off" placeholder="请输入11位手机号" id="phone">
                            <i class="remove icon mobile-error-icon"></i>
                            <i class="checkmark icon mobile-success-icon"></i>
                            <div id="sendCode" class="send-code-box">验证</div>
                        </li>
                        <li class="input-list identify-code input-left-style input-top-style">
                            <i class="send icon"></i>
                            <input type="text" placeholder="请输入收到的验证码" autocomplete="off" id="code">
                            <i class="remove icon code-error-icon"></i>
                            <i class="checkmark icon code-success-icon"></i>
                        </li>
                        <li class="reg-btn register-prev" id="register">
                            <div  id="regBtn" class="div-btn">注册</div>
                        </li>
                        <li class="reg-btn register-now loading">
                            <div class="div-btn">正在提交</div>
                            <div class="ui active inline loader"></div>
                        </li>
                    </ul>
                </div>
            </form>
            <div class="back-login">

                <a href="/login"><i class="reply icon"></i>已有账号,返回登录</a>
            </div>
            <div class="success-box">
                <h2>恭喜您,注册成功!</h2>
                <h3>全球精品酒店欢迎您的加入~</h3>
                <p>即将跳转页面......</p>
            </div>
        </div>
        <div class="copy-footer" style="margin-left: 30%;">

            <span class="up">全球精品酒店 版权所有 2016-2028 保留所有权利 </span>
            <span class="down"> All rights reserved. 闽ICP备16016886号</span>

        </div>
    </div>
@stop

@section('script')
    <script>

        $(function(){

            $('.username-error-icon').hide();
            $('.email-error-icon').hide();
            $('.mobile-error-icon').hide();
            $('.pwd-error-icon').hide();
            $('.password-error-icon').hide();

            $('.username-success-icon').hide();
            $('.email-success-icon').hide();
            $('.mobile-success-icon').hide();
            $('.pwd-success-icon').hide();
            $('.password-success-icon').hide();

            //用户验证
            $("#username").change(function(){

                var pregUser = /[A-Za-z0-9_-]{6,}/;

                if($(this).val() == ""){
                    $('.username-error-icon').show();
                    $('.username-success-icon').hide();
                    toastAlert('用户名不能为空',1);
                    return false;
                }

                if($(this).val().length > 12 || $(this).val().length < 6){
                    $('.username-error-icon').show();
                    $('.username-success-icon').hide();
                    toastAlert('用户名长度不够',1);
                    return false;
                }

                if(!pregUser.test($(this).val())){
                    $('.username-error-icon').show();
                    $('.username-success-icon').hide();
                    toastAlert('用户名包含非法字符',1);
                    return false;
                }

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/userSession',
                    data:{username:$("#username").val()},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data == 2){
                            $('.username-error-icon').hide();
                            $('.username-success-icon').show();
                        }else{
                            $('.username-error-icon').show();
                            $('.username-success-icon').hide();
                            toastAlert('用户名已注册',1);
                        }
                    }
                });

            });

            //邮箱验证
            $("#email").change(function(){

                var pregEmail = /\w[-\.\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,14}/;

                if($(this).val() == ""){
                    $('.email-error-icon').show();
                    $('.email-success-icon').hide();
                    toastAlert('邮箱不能为空',1);
                    return false;
                }

                if(!pregEmail.test($(this).val())){
                    $('.email-error-icon').show();
                    $('.email-success-icon').hide();
                    toastAlert('邮箱格式不正确',1);
                    return false;
                }

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/checkEmail',
                    data:{email:$("#email").val()},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data == 2){

                            $('.email-error-icon').hide();
                            $('.email-success-icon').show();

                        }else {
                            toastAlert('邮箱已注册',1);
                            $('.email-error-icon').show();
                            $('.email-success-icon').hide();
                            return false;
                        }
                    }
                });

            });

            //密码验证
            $('#password').change(function(){

                if($(this).val() == ""){
                    $('.password-error-icon').show();
                    $('.password-success-icon').hide();
                    toastAlert('密码不能为空',1);
                    return false;
                }
                else if($(this).val().length < 6){
                    $('.password-error-icon').show();
                    $('.password-success-icon').hide();
                    toastAlert('密码长度不能少于6位',1);
                    return false;
                }

                $('.password-error-icon').hide();
                $('.password-success-icon').show();


            });
            $("#pwd").change(function(){

                if($(this).val() != $("#password").val()){
                    $('.pwd-error-icon').show();
                    $('.pwd-success-icon').hide();
                    toastAlert('两次密码不一致请检查',1);
                    return false;
                }

                $('.pwd-error-icon').hide();
                $('.pwd-success-icon').show();


            });

            //手机号验证
            $("#phone").change(function(){

                var pregPhone = /13[0-9]{9}|14[0-9]{9}|15[0-9]{9}|17[0-9]{9}|18[0-9]{9}/;
                if($(this).val() == ""){
                    $('.mobile-error-icon').show();
                    $('.mobile-success-icon').hide();
                    toastAlert('手机号不能为空',1);
                    return false;
                }

                if(!pregPhone.test($(this).val())){
                    $('.mobile-error-icon').show();
                    $('.mobile-success-icon').hide();
                    toastAlert('手机号码格式不正确',1);
                    return false;
                }

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/checkMobile',
                    data:{mobile: $.trim($('#phone').val()),type:1},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){

                        if(data==2){

                            $('.mobile-success-icon').show();
                            $('.mobile-error-icon').hide();

                        }else{
                            toastAlert('手机号已经注册过',1);
                            $('.mobile-success-icon').hide();
                            $('.mobile-error-icon').show();
                            return false;
                        }

                    },
                    error:function(){
                        toastAlert('错误',1);
                        $('.mobile-success-icon').hide();
                        $('.mobile-error-icon').show();
                        return false;
                    }
                });
            });

            //验证码
            $("#code").change(function(){

                if($(this).val() == ''){
                    $('.code-error-icon').show();
                    $('.code-success-icon').hide();
                    toastAlert('验证码不能为空',1);
                    return false;
                }

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/checkCode',
                    data:{mobile:$("#phone").val(),code:$("#code").val()},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data==1){

                            $('.code-error-icon').hide();
                            $('.code-success-icon').show();

                        }else{
                            $('.code-error-icon').show();
                            $('.code-success-icon').hide();
                            toastAlert('错误:验证码有误',1);
                            return false;
                        }

                    },
                    error:function(){
                        toastAlert('错误',1);
                        return false;
                    }
                });

            });

            $("#regBtn").click(function(){


                var username = $("#username").val();
                var password = $("#password").val();
                var pwd      = $("#pwd").val();
                var email    = $("#email").val();
                var phone    = $("#phone").val();
                var code     = $("#code").val();

                if(username == ""){
                    toastAlert('请输入用户名',1);
                    $('.username-error-icon').show();
                    return false;
                }
                if(password == ""){
                    toastAlert('请输入密码',1);
                    $('.password-error-icon').show();
                    return false;
                }
                if(pwd == ""){
                    toastAlert('请再次输入密码',1);
                    $('.pwd-error-icon').show();
                    return false;
                }
                if(email == ""){
                    toastAlert('请输入邮箱',1);
                    $('.email-error-icon').show();
                    return false;
                }
                if(phone == ""){
                    toastAlert('请输入手机号',1);
                    $('.mobile-error-icon').show();
                    return false;
                }
                if(code == ""){
                    toastAlert('请输入验证码',1);
                    $('.code-error-icon').show();
                    return false;
                }


                //格式验证
                var pregUser = /[A-Za-z0-9_-]{6,}/;
                var pregEmail = /\w[-\.\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,14}/;
                var pregPhone = /13[0-9]{9}|14[0-9]{9}|15[0-9]{9}|17[0-9]{9}|18[0-9]{9}/;


                if(!pregUser.test(username)){
                    toastAlert('用户名长度不够或包含非法字符',1);
                    $('.username-error-icon').show();
                    $("#username").focus();
                    return false;
                }

                if(!pregEmail.test(email)){
                    toastAlert('邮箱格式不正确',1);
                    $('.email-error-icon').show();
                    return false;
                }
                if(!pregPhone.test(phone)){
                    toastAlert('手机号码格式不正确',1);
                    $('.mobile-error-icon').show();
                    return false;
                }

                if(password != pwd){
                    toastAlert('两次密码输入不一样,请检查',1);
                    $('.pwd-error-icon').show();
                    return false;
                }


                //用户验证
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/userSession',
                    data:{username:username},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data==2){

                            $('.username-error-icon').hide();

                            //邮箱验证
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
                                    if(data == 2){

                                        $('.email-error-icon').hide();

                                        //验证码
                                        $.ajax({
                                            type:'POST',
                                            async:false,
                                            url:'/checkCode',
                                            data:{mobile:phone,code:code},
                                            dataType:'json',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            },
                                            success:function(data){
                                                if(data==1){
//                                                    $("#regBtn").html('正在提交<div class="ui active inline loader"></div>');

                                                    $('.code-error-icon').hide();

                                                    $('.register-prev').css('display','none');
                                                    $('.register-now').removeClass('loading');

                                                    function jumLogin(){
                                                        //AJAXFORM表单提交
                                                        $("#regForm").ajaxSubmit(options);
                                                    }

                                                    setTimeout(jumLogin,2000);

                                                }else{
                                                    toastAlert('错误:验证码有误',1);
                                                    $('.code-error-icon').show();
                                                    return false;
                                                }

                                            },
                                            error:function(){
                                                toastAlert('错误:验证码有误',1);
                                                $('.code-error-icon').show();
                                                return false;
                                            }
                                        });
                                    }else {
                                        toastAlert('邮箱已注册',1);
                                        $('.email-error-icon').show();
                                        return false;
                                    }
                                }
                            });
                        }else {
                            toastAlert('用户名已注册',1);
                            $('.username-error-icon').show();
                            return false;
                        }
                    }
                });

            });


            //发送验证码
            $("#sendCode").click(function(){

                var sendBtn = $(this);

                if($("#phone").val()==""){
                    toastAlert('手机号不能为空',1);
                    $("#phone").focus();
                    return false;
                }


                //验证手机号
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/checkMobile',
                    data:{mobile: $.trim($('#phone').val()),type:1},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){

                        if(data==2){
                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/sendCode',
                                data:{mobile:$.trim($('#phone').val()),type:1},
                                dataType:'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                                success:function(data){
                                    if(data == 1){

                                        $('.mobile-success-icon').show();
                                        $('.mobile-error-icon').hide();

                                        //验证码发送成功
                                        settime(sendBtn);
                                    }else{
                                        sendBtn.text('发送验证码');
                                    }
                                },
                                error:function(){
                                    toastAlert('错误:手机号无效',1);
                                    $('.mobile-success-icon').hide();
                                    $('.mobile-error-icon').show();
                                    return false;
                                }
                            });
                        }else{
                            toastAlert('错误:手机号已经注册过',1);
                            $('.mobile-success-icon').hide();
                            $('.mobile-error-icon').show();
                            return false;
                        }

                    },
                    error:function(){
                        toastAlert('错误',1);
                        $('.mobile-success-icon').hide();
                        $('.mobile-error-icon').show();
                        return false;
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
                obj.text(countdown+'秒后可重发' );
                obj.attr('disabled','disabled');
                countdown--;
            }
            setTimeout(function() {
                        settime(obj) }
                    ,1000)
        }

        //AjaxForm验证表单
        var options = {
//            target: '#output',          //把服务器返回的内容放入id为output的元素中
            beforeSubmit: showRequest,  //提交前的回调函数
            success: showResponse,      //提交后的回调函数
//            url: '/auth/register', //默认是form的action， 如果申明，则会覆盖
//            type: post,                 //默认是form的method（get or post），如果申明，则会覆盖
            //dataType: null,           //html(默认), xml, script, json...接受服务端返回的类型
//            clearForm: true,          //成功提交后，清除所有表单元素的值
            //resetForm: true,          //成功提交后，重置所有表单元素的值
//            error:    howError,
            timeout: 6000               //限制请求的时间，当请求大于6秒后，跳出请求
        }

        //提交前的回调函数
        function showRequest(formData, jqForm){
            for(var i=0; i < formData.length; i++ ){
                if(!formData[i].value){
                    toastAlert('不可以有空值',1);
                    return false;
                }
            }
            //通过ID验证表单值
            var form = jqForm[0];
            var pregUser = /[A-Za-z0-9_-]{6,}/;
            var pregEmail = /\w[-\.\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,14}/;
            var pregPhone = /13[0-9]{9}|14[0-9]{9}|15[0-9]{9}|17[0-9]{9}|18[0-9]{9}/;

            if(!pregUser.test(form.username.value)){
                toastAlert('用户名长度不够或包含非法字符',1);
                $("#username").focus();
                return false;
            }
            if(!pregEmail.test(form.email.value)){
                toastAlert('邮箱格式不正确',1);
                return false;
            }
            if(!pregPhone.test(form.phone.value)){
                toastAlert('手机号码格式不正确',1);
                return false;
            }

            if(form.password.value != form.pwd.value){
                toastAlert('两次密码输入不一样,请检查',1);
                return false;
            }



        }
        //提交后的回调函数
        function showResponse(responseText){


            if(responseText){
                var res = JSON.parse(responseText);

                if(res.statusCode === 1){
                    toastAlert('注册失败:该用户名已经注册过',1);
                    $('.username-error-icon').show();
                    return false;
                }

                if(res.statusCode === 2){
                    toastAlert('注册失败:该邮箱已经注册过',1);
                    $('.email-error-icon').show();
                    return false;
                }

                if(res.statusCode === 3){
                    toastAlert('注册失败:该手机号已经注册过',1);
                    $('.mobile-error-icon').show();
                    return false;
                }

            }else{
                $("#regForm").fadeOut();
                $('.back-login').fadeOut();
                $(".success-box").fadeIn();

                //注册成功,跳转页面.
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/registersuccess',
                    data:{username:$("#username").val()},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        function jumLogin(){
                            window.location.href = '/regSuccess';
                        }

                        setTimeout(jumLogin,3000);
                    }
                });

            }


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