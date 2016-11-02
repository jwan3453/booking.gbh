<?php

namespace App\Service\Booking;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Continent;
use App\Models\InternationalCity;
use App\Models\Hotel;
use App\Models\Address;
use App\Models\HotelImage;
use App\Models\HotelSurrounding;
use App\Models\HotelPolicy;
use App\Models\HotelSection;
use App\Models\Room;
use App\Models\Category;
use App\Models\HotelFacility;
use App\Models\HotelFacilityList;
use App\Models\HotelFacilityCategory;
use Illuminate\Support\Facades\DB;



/**
 *
 */
class BookingService{



    //获取推荐的酒店
    public function getSelectedHotels()
    {
        return Hotel::all();
    }

    //获取酒店分类
    public function getCategories()
    {
        return Category::where('parent_id',3)->get();
    }

    //获取热门目的地
    public function getHotelDestination()
    {

        $cityList = DB::table('destination')->Join('city','destination.city_code','=','city.code')->where('city.is_hot',1)->select('destination.cover_image','city.code','city.city_name','city.city_name_en')->take(7)->get();

        return  $cityList;
    }


    //获取城市目的地
    public function getDestinationCities()
    {


        $destinationList = [];

        //国内城市
        $cityList = City::where('status',1)->select('initial','code','city_name','city_name_en','is_hot')->orderby('initial','asc')->get();//where('status', 0);
        $hotDestination =[];


        //按照首字母给城市分组

        $cityInitialList = [];
        $tempCityArray = [];
        $previous = '';
        for($i=0; $i<count($cityList);    $i++)
        {

            if($cityList[$i]->is_hot == 1)
            {
                $hotDestination[] =$cityList[$i];

            }
            if(strcmp($cityList[$i]->initial, "")!=0)
            {
                if(strcmp($previous, $cityList[$i]->initial)==0)
                {
                    $previous =  $cityList[$i]->initial;
                    $tempCityArray[] =  $cityList[$i];
                }
                else{

                    $cityInitialList[ $previous] = $tempCityArray;
                    $tempCityArray = [];
                    $tempCityArray[] =  $cityList[$i];
                    $previous =  $cityList[$i]->initial;
                }


                if($i == (count($cityList) -1))
                {
                    $cityInitialList[ $cityList[$i]->initial] = $tempCityArray;
                }
            }
        }

        $cityInitialList['hotDestination'] = $hotDestination;
        $destinationList['domestic'] = $cityInitialList;

        //国际城市
        $internationalCity = [];
        $continentList = [];
        $continents = Continent::all();
        foreach($continents as $continent )
        {

            $internationalCity[$continent->name_en] =DB::table('international_city')->join('country','international_city.country_code','=','country.code')
                ->join('continent','country.continent_id','=','continent.id')->where('continent.id',$continent->id)->select('international_city.*')->get();
            $continentList[] = ['name'=>$continent->name,'name_en'=>$continent->name_en];
        }
        $internationalCity['hotDestination'] = InternationalCity::where('is_hot',1)->get();
        $internationalCity['continentList'] =  $continentList;
        $destinationList['international'] = $internationalCity;

        dd($internationalCity);
        return $destinationList;

    }


    //获取酒店详细信息
    public function getHotelDetail($hotelId)
    {

        $hotel = Hotel::where('id',$hotelId)->firstOrFail();

        $sectionImageList = [];
        $sectionList = [];
        $hotelSections = HotelSection::all();
        $hotelRoomList = Room::where('hotel_Id',$hotelId)->select('id','room_name','room_name_en')->get();

        //获取酒店区域照片
        foreach($hotelSections as $section)
        {
            $images = HotelImage::where(['hotel_id'=>$hotelId,'section_id'=> $section->id,'hotel_id' => $hotelId,'type'=>1])->get();
            if(count($images) > 0 )
            {

                $sectionName = '';

                if(session('lang') == 'en')
                    $sectionName= $section->name_en;
                else
                    $sectionName= $section->name;

                $sectionImageList[$sectionName] = $images;


                foreach($images as $image)
                {

                        $image->section_name =$sectionName;

                }

                    array_push($sectionList,$sectionName);


            }
        }
        //获取酒店房间照片
        $roomImages = HotelImage::where(['hotel_id' => $hotelId,'type'=>2])->get();



        //给照片附上房间类型
        foreach($hotelRoomList as $room)
        {
            foreach($roomImages as  $image)
            {
                if($image->section_id == $room->id)
                {

                    if(session('lang') == 'en')
                        $image->section_name = $room->room_name_en;
                    else
                        $image->section_name = $room->room_name;
                }
            }
        }



        if(session('lang') == 'en')
        {
            $sectionImageList['room'] = $roomImages;
            array_push($sectionList,'room');
        }
        else
        {
            $sectionImageList['房间'] = $roomImages;
            array_push($sectionList,'房间');
        }



        //获取酒店设施列表
        $facilities = [];
        $facilities['settings'] = HotelFacility::where('hotel_id', $hotelId)->select('facilities_checkbox')->first();

        if($facilities['settings'] != null)
        {

            $facilityArray = explode(',',$facilities['settings']->facilities_checkbox);

            $facilities['category'] =  HotelFacilityCategory::all();
            $facilitiesList = [];
            foreach($facilities['category'] as $category)
            {
                $tempFacilityList= HotelFacilityList::where('category',$category->id)->get();
                foreach(  $tempFacilityList as $k=>$facilityItem)
                {
                    if(!in_array($facilityItem->id,$facilityArray))
                    {

                        unset($tempFacilityList[$k]);
                    }
                }


                $facilitiesList[$category->id] = $tempFacilityList;
            }
            $facilities['list'] = $facilitiesList;
            $hotel->facility = $facilities;
        }




        //获取房间列表
        $hotel->rooms= Room::where('hotel_id',$hotel->id)->get();
        foreach( $hotel->rooms as  $room)
        {
            $room->images = HotelImage::where(['section_id'=> $room->id,'hotel_id' => $hotelId,'type'=>2])->get();
        }

        //获取酒店区域列表
        $hotel->sectionList = $sectionList;

        //获取酒店图片列表
        $hotel->hotelImageList = $sectionImageList;

        $hotel->coverImageList = HotelImage::where('hotel_id' ,$hotel->id)->where('is_cover','<>',0)->get();
        $hotel->surroundingList  = HotelSurrounding::where('hotel_id',$hotel->id)->get();


        $hotel->address = Address::where('id',$hotel->address_id)->first();
        $hotel->province  = $this->getAdressInfo('province',$hotel->address->province_code);
        $hotel->city  = $this->getAdressInfo('city',$hotel->address->city_code);
        $hotel->district  = $this->getAdressInfo('district',$hotel->address->district_code);

        $hotel->policy =  HotelPolicy::where('hotel_id',$hotelId)->first();


        return $hotel;
    }



    //根据分类获取酒店列表

    public function getHotelByCate($category)
    {
       // $hotelList = Hotel::where('category_id',$category)->get();


        $hotel['category'] = Category::where('id',$category)->FirstOrFail();//->select('category_name','category_name_en','icon')->FirstOrFail();
        $hotel['list'] = DB::table('hotel')->join('hotel_image','hotel.id','=','hotel_image.hotel_id')
                         ->join('address','hotel.address_id','=','address.id')
                         ->join('city','address.city_code','=','city.code')
                        ->join('province','address.province_code','=','province.code')
                        ->where('hotel_image.is_cover',2)->select('hotel.*','province.province_name','province.province_name_en','city.city_name','city.city_name_en','address.detail','address.detail_en','hotel_image.link')->get();


        //dd($category);

        return $hotel;
    }


    //通过目的地获取酒店
    public function getHotelByCity($code)
    {

        $hotel['cityName']= City::where('code',$code)->select('city_name','city_name_en')->firstOrFail();

        $hotel['list'] =DB::table('hotel')->join('hotel_image','hotel.id','=','hotel_image.hotel_id')
            ->join('address','hotel.address_id','=','address.id')
            ->join('city','address.city_code','=','city.code')
            ->join('province','address.province_code','=','province.code')
            ->where(['address.city_code'=>$code,'hotel_image.is_cover'=>2])
            ->select('hotel.*','province.province_name','province.province_name_en','city.city_name','city.city_name_en','address.detail','address.detail_en','hotel_image.link')->get();




        return $hotel;
    }




    //获取所有上线目的地
    public function getDestinationList()
    {


        //国内城市
        //直辖市

        $destinationList = [];
        $adg = [110000,120000,310000,500000,810000,820000];
        $provinceList = DB::table('province')->where('status',1)->whereNotIn('code',$adg)->select('code','province_name','province_name_en')->get();

        $adgList=DB::table('city')->join('destination','city.code','=','destination.city_code')
            ->select('city.code','city.city_name','city.city_name_en','destination.num_of_hotel','destination.description','destination.description_en','destination.cover_image')->where('city.status',1)->whereIn('city.province_code',$adg)->get();


        foreach($provinceList as $province)
        {
            if(!in_array($province->code,$adg))
            {
                $province->cityList = DB::table('city')->leftJoin('destination','city.code','=','destination.city_code')
                    ->select('city.code','city.city_name','city.city_name_en','destination.num_of_hotel','destination.description','destination.description_en','destination.cover_image')
                    ->where(['province_code'=>$province->code,'status'=>1])->get();
            }

        }

        $destinationList['adgList'] = $adgList;
        $destinationList['provinceList'] = $provinceList;


        //国际城市
        $continents =  Continent::all();
        foreach($continents as $continent)
        {
            $continent->cityList = DB::table('international_city')->join('country','international_city.country_code','=','country.code')
                ->join('continent','country.continent_id','=','continent.id')->join('destination','international_city.code','=','destination.city_code')
                ->select('international_city.code','international_city.city_name','international_city.city_name_en','destination.num_of_hotel','destination.description','destination.description_en','destination.cover_image')
                ->where('continent.id',$continent->id)->get();



        }
        $destinationList['continent'] = $continents;

        return $destinationList;

    }





    //获取省市县区
    /*
   *  level = city|province|district
   */
    public function getAdressInfo($level = '' , $code = 110000)
    {
        if ($level == '') {
            return false;
        }
        $info = '';
        switch ($level) {
            case 'city':
                $info = City::select('city_name','city_name_en')->where('code',$code)->first();
                break;
            case 'province':
                $info = Province::select('province_name','province_name_en')->where('code',$code)->first();
                break;
            case 'district':
                $info = District::select('district_name')->where('code',$code)->first();
                break;
            default:
                $info = "未知";
                break;
        }

        return $info;


    }




}


?>