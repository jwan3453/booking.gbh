<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Service\Booking\BookingService;
use App\Tool\MessageResult;

use App;

class BookingController extends Controller
{



    private $bookingService;


    public function __construct(BookingService $bookingService){

        //设置语言


        if(session('lang') == null)
        {
            session(['lang'=>'zh_cn']);

        }
        App::setLocale(session('lang'));
        $this->bookingService = $bookingService;
    }




    //酒店预订首页
    public function home()
    {

        $isMobile = false;
        if($this->check_wap())
            $isMobile = true;

        $selectedHotels = $this->bookingService->getSelectedHotels();
        $categories = $this->bookingService->getCategories();
        $hotDestination = $this->bookingService->getHotelDestination();

        return view('booking.home')->with('isMobile',$isMobile)->with('selectedHotels',$selectedHotels)->with('categories',$categories)->with('hotDestination',$hotDestination);
    }


    //搜索关键词
    public function search($keyword)
    {
        $destinationList =  $this->bookingService->getDestinationCitiesHotels();

        //搜索国内城市
        foreach($destinationList['domestic'] as $initial => $cityList)
        {
            if($initial != '')
            {
                //dd($cityList);
                foreach($cityList as $city)
                {

                    if(stripos($city->city_name,$keyword)!== false || stripos($city->city_name_en,$keyword) !== false )
                    {
                        //找到城市返回
                       return redirect('hotelByCity/ds/'.$city->code);
                    }
                }
            }

        }


        //搜索国际城市
        foreach($destinationList['international'] as $key => $cityList)
        {
            if($key != '' && $key != 'hotDestination' && $key != 'continentList')
            {
                //dd($cityList);
                foreach($cityList as $city)
                {

                    if(stripos($city->city_name,$keyword)!== false || stripos($city->city_name_en,$keyword) !== false )
                    {
                        //找到城市返回
                        return redirect('hotelByCity/int/'.$city->code);
                    }
                }
            }

        }

        //搜索酒店
        foreach($destinationList['hotel'] as $key => $hotel)
        {
            if(stripos($hotel->name,$keyword)!== false || stripos($hotel->name_en,$keyword) !== false )
            {
                return redirect('hotel/'.$hotel->code);
            }
        }


        return view('booking.noResult');
    }

    //ajax 回去目的地列表
    public function getDestinationCitiesHotels(Request $request)
    {
        $jsonResult = new MessageResult();
        $destinationList =  $this->bookingService->getDestinationCitiesHotels();
        $jsonResult->statusCode =1;
        $jsonResult->StatusMsg = '';
        $jsonResult->extra = $destinationList;
        return response($jsonResult->toJson());
    }


    //酒店详情页
    public function hotelDetail($code)
    {

        $hotelDetail =  $this->bookingService->getHotelDetail($code);
        return view('booking.hotel')->with('hotelDetail',$hotelDetail);
    }


    //
    public function hotelCategory($category)
    {
        $hotel = $this->bookingService->getHotelByCate($category);
        return view('booking.hotelByCategory')->with('hotel',$hotel);

    }


    //目的地
    public function destinationList()
    {
        $destinationList = $this->bookingService->getDestinationList();
        return view('booking.destinationList')->with('destinationList',$destinationList);
    }


    //目的地酒店
    public function hotelByCity($area,$code)
    {
        $hotel = $this->bookingService->getHotelByCity($area,$code);
        return view('booking.hotelByCity')->with('hotel',$hotel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * 判断是手机访问pc访问
     */
    protected function check_wap() {
        if (isset($_SERVER['HTTP_VIA'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_NOKIA_CONNECTION_MODE'])) {
            return true;
        }
        if (isset($_SERVER['HTTP_X_UP_CALLING_LINE_ID'])) {
            return true;
        }
        if (strpos(strtoupper($_SERVER['HTTP_ACCEPT']), "VND.WAP.WML") > 0) {
            // Check whether the browser/gateway says it accepts WML.
            $br = "WML";
        } else {
            $browser = isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : '';
            if (empty($browser)) {
                return true;
            }
            $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');

            $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');

            $found_mobile = $this->checkSubstrs($mobile_os_list, $browser) || $this->checkSubstrs($mobile_token_list, $browser);
            if ($found_mobile) {
                $br = "WML";
            } else {
                $br = "WWW";
            }
        }
        if ($br == "WML") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断手机访问， pc访问
     */
    protected function checkSubstrs($list, $str) {
        $flag = false;
        for ($i = 0; $i < count($list); $i++) {
            if (strpos($str, $list[$i]) > 0) {
                $flag = true;
                break;
            }
        }
        return $flag;
    }



    public function testDest()
    {
        $cityInitialList =  $this->bookingService->getDestinationCities();
        dd($cityInitialList);
    }
}
