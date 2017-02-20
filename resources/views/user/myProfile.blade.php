
@extends('user.userLayout')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{asset('/js/jcrop/css/jquery.Jcrop.min.css') }}>

    <script src={{ asset('/js/jcrop/js/jquery.Jcrop.min.js') }}></script>
@stop



@section('user-center-right')
    <div class="profile-detail">

        <form  method="POST" action="/uploadAvatar" accept-charset="UTF-8" id="upload" enctype="multipart/form-data">
            <div class="profile-line-detail">
                <label>用户头像:</label>
                <img src = '{{$userDetail['avatar']==null?'/booking/img/defaultImage.png': $userDetail['avatar']->link.$userDetail['avatar']->coords}}' id="avatarImage">
                <span class="edit-profile" id="editProfile">点击修改资料</span><i class="icon edit "></i>
                <input type="file" id="avatarFile" name="avatarFile">
                <input type="hidden" name="imageType" value="1">

            </div>
        </form>

        <form  id="profileForm" method="post" action="/saveprofile">
            <div class="profile-line-detail">
                <label>用户名:</label>
                <input type="text" value="{{$userDetail['stable']==null?'': $userDetail['stable']->username}}" id="userName" name="userName">
            </div>
            <div class="profile-line-detail">
                <label>邮箱:</label>
                <input type="text" value="{{$userDetail['stable']==null?'': $userDetail['stable']->email}}" id="email" name="email">
            </div>
            <div class="profile-line-detail">
                <label>生日:</label>
                <select id="year" name="year">
                    @foreach($year as $y)
                        @if($userDetail['detail']!=null && $userDetail['detail']->birth_year == $y)
                            <option selected value="{{$y}}">{{$y}} 年</option>
                        @else
                            <option  value="{{$y}}">{{$y}} 年</option>
                        @endif
                    @endforeach

                </select>

                <select id="month" name="month">
                    @foreach($month as $m)
                        @if($userDetail['detail']!=null && $userDetail['detail']->birth_month == $m)
                            <option selected value="{{$m}}">{{$m}} 月</option>
                        @else
                            <option  value="{{$m}}">{{$m}} 月</option>
                        @endif
                    @endforeach
                </select>

                <select id="day" name="day">

                    @foreach($day as $d)
                        @if($userDetail['detail']!=null && $userDetail['detail']->birth_day == $d)
                            <option selected value="{{$d}}">{{$d}} 日</option>
                        @else
                            <option  value="{{$d}}">{{$d}} 日</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="profile-line-detail">
                <label>自我介绍:</label>
                <textarea  id="signature" name="signature">{{$userDetail['detail']==null?'': $userDetail['detail']->signature}}</textarea>
            </div>

            <div style="width:686px; margin:20px 0 0 125px;">
                <div id="submitProfile" class="regular-btn long-btn outline-btn  ">
                    保存
                </div>

            </div>
        </form>
    </div>

    <div class="screen-mask">
    </div>


    <form class="image-crop-box" method="post" action="/avatar/corp" onsubmit="return checkCoordinates()">
        <div class="h">
            裁剪头像
        </div>

        <i class="icon remove large"></i>
        <div class="crop-content">
            <img src="" id="cropImage">
            <input type="hidden" id="imageKey" name="imageKey" />
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="width" name="width" />
            <input type="hidden" id="height" name="height" />
        </div>

        <div style="margin-top:10px;">
            <button class="regular-btn red-btn">
                确认裁剪
            </button>

        </div>
    </form>


@stop



@section('script')

    <script >

        $(document).ready(function(){




            var options = {
                beforeSubmit: showRequest,
                success: showResponse,
                dataType: 'json'
            };


            $('input').attr("readonly","readonly");
            $('textarea').attr("readonly","readonly");
            $('select').attr('disabled','disabled');

            var editMode = false;

            $('#editProfile').click(function(){

                if(editMode == true)
                {
                    editMode = false;

//                    $('input').attr("readonly","readonly").removeClass('active-input');
                    $('textarea').attr("readonly","readonly").removeClass('active-input');
                    $('select').attr('disabled','disabled');
                    $('#editProfile').text('点击修改资料');
                    $('#submitProfile').addClass('outline-btn').removeClass('red-btn');
                }
                else
                {
                    editMode = true;
//                    $('input').removeAttr("readonly","readonly").addClass('active-input');
                    $('textarea').removeAttr("readonly","readonly").addClass('active-input');
                    $('select').removeAttr('disabled','disabled');
                    $('#editProfile').text('取消修改');
                    $('#userName').focus();
                    $('#submitProfile').addClass('red-btn').removeClass('outline-btn');
                }

            })

            $('#avatarImage').click(function(){
                $('#avatarFile').click();
            })

            $('#avatarFile').change(function(){
                $('#upload').ajaxForm(options).submit();
            })
            function showRequest() {

                return true;
            }


            function showResponse(data) {

                if (parseInt(data.statusCode) === 1) {

                    $('.screen-mask').show();
                    $('.image-crop-box').fadeIn();
                    var cropBox = $("#cropImage");
                    cropBox.attr('src', data.extra.link);
                    $('#imageKey').val(data.extra.image_key);
                    cropBox.Jcrop({
                        aspectRatio: 1,
                        onSelect: updateCoordinates,
                        addClass: 'jcrop-centered',
                        setSelect: [120, 120, 10, 10]
                    });
                    $('.jcrop-holder img').attr('src',data.extra.link);

                } else {
                    toastAlert('图片上传失败',2);
                }
            }

            //如何没有裁剪就提示
            function   checkCoordinates(){
                if( parseInt($('#width').val()) )
                    return true;
                else{
                    toastAlert('请选择图片',2);

                    return false;
                }
            }

            //接受选择的裁剪图片坐标
            function updateCoordinates(coor) {
                $('#x').val(coor.x);
                $('#y').val(coor.y);
                $('#width').val(coor.w);
                $('#height').val(coor.h);
            }

            //关闭图片裁剪框
            $('.remove').click(function(){
                $('.screen-mask').hide();
                $('.image-crop-box').fadeOut();
            })


            $('#submitProfile').click(function(){
                if(editMode)
                    $('#profileForm').submit();
                else
                return false;
            })

        })

    </script>
@stop