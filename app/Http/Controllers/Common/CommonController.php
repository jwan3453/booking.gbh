<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Booking\BookingService;
use App\Tool\MessageResult;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


use App;

class CommonController extends Controller
{


    public function __construct(BookingService $bookingService){


    }

    //设置语言
    public function setLang($lang)
    {

        session(['lang'=>$lang]);

        return Redirect::back();

    }



}
