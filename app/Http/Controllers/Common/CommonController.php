<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Booking\BookingService;
use App\Service\Common\ImageService;
use App\Tool\MessageResult;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App;

class CommonController extends Controller
{

    private $imageService;

    public function __construct( ImageService $imageService ){

        $this->imageService = $imageService;
    }

    //设置语言
    public function setLang($lang)
    {

        session(['lang'=>$lang]);
        return Redirect::back();

    }

    //上传头像
    public function uploadAvatar(Request $request)
    {

        $jsonResult = $this->imageService->uploadImage($request);
        return response($jsonResult->toJson());
    }

    //更新头像裁剪坐标
    public function cropAvatar(Request $request)
    {
        $jsonResult   =    $this->imageService->cropAvatar($request);
        return redirect('/user/myprofile');
    }

}
