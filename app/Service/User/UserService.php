<?php


namespace App\Service\User;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Address;
use App\Models\HotelImage;
use App\Service\Booking\BookingService;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;


/**
 *
 */
class UserService {

    //获取推荐的酒店
    public function getRoomDetail($hotelId, $roomId, $checkInDate, $checkOutDate)
    {
        $hotelRoomDetail=[];


        $hotelDetail =  Hotel::where('id',$hotelId)->firstOrFail();
        $hotelDetail->address = Address::where('id',$hotelDetail->address_id)->first();
        if($hotelDetail->address != null)
        {
            $hotelDetail->province  = (new BookingService())->getAdressInfo('province',$hotelDetail->address->province_code,$hotelDetail->address->type);
            $hotelDetail->city  = (new BookingService())->getAdressInfo('city',$hotelDetail->address->city_code,$hotelDetail->address->type);
            $hotelDetail->district  = (new BookingService())->getAdressInfo('district',$hotelDetail->address->district_code,$hotelDetail->address->type);
        }


        $roomDetail = Room::where(['id'=>$roomId])->firstOrFail();
        $averagePrice = $this->getOfferPrice($hotelId,$roomId, $checkInDate, $checkOutDate);

        $roomDetail->imageLink=HotelImage::where(['section_id'=> $roomDetail->id,'hotel_id' => $hotelId,'type'=>2])->first()->link;

        $hotelRoomDetail['hotel'] = $hotelDetail;
        $hotelRoomDetail['room'] = $roomDetail;

        $dateDiff = (new BookingService())->diffBetweenTwoDays($checkInDate, $checkOutDate) ;
        $hotelRoomDetail['averagePrice'] = $averagePrice;
        $hotelRoomDetail['totalAmount'] = $averagePrice * $dateDiff;
        $hotelRoomDetail['dateDiff'] = $dateDiff;
        return $hotelRoomDetail;
    }



    //
    public function searchPriceByDate($hotelId,$roomId,$checkInDate,$checkOutDate,$numOfRoom)
    {
        dd('en');
        $getPrice = $this->getOfferPrice($hotelId,$roomId,$checkInDate,$checkOutDate,$numOfRoom);

        return $getPrice;
    }



    //获取房价
    public function getOfferPrice($hotelId,$roomId, $checkInDate, $checkOutDate, $numOfRoom = 1)
    {

        $checkOutDate = date('Y-m-d',strtotime('+1 d',strtotime($checkOutDate)));
        //到店日期和离店日期的间隔
        $dateDiff = (new BookingService())->diffBetweenTwoDays($checkInDate, $checkOutDate)+1;

        //获取房态列表
        $roomStatus  =DB::table('room_status') ->whereBetween('date', array($checkInDate, $checkOutDate))->where('room_id',$roomId)->get();

        //获取房价列表
        $roomPrice = DB::table('room_price') ->whereBetween('date', array($checkInDate, $checkOutDate))->where('room_id',$roomId)->get();


        $hasRoomCount = 0;
        $avgPrice = 0;
        foreach($roomStatus as $status)
        {

            //现付
            if(($status->num_of_blocked_room - $status->num_of_sold_room ) >=$numOfRoom && $status->room_status == 1  )
            {
                    $hasRoomCount++;
            }
                //预付
        }

        if($dateDiff ===$hasRoomCount )//有房
        {
            foreach($roomPrice  as $price)
            {
                $avgPrice += $price->rate;
            }

            return ($avgPrice/$dateDiff) ;
        }
        //无房
        else{
            return 0;
        }


    }




}


?>