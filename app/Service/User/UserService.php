<?php


namespace App\Service\User;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Address;
use App\Models\HotelImage;
use App\Models\UserProfile;
use App\Models\Orders;
use App\Models\UserImage;
use App\Models\UserCollection;
use App\Service\Booking\BookingService;
use App\Service\Order\OrderService;
use App\User;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;



;
/**
 *
 */
class UserService {

    //获取所有订单

    private $orderService;
    private $bookingService;

    public function __construct(OrderService $orderService,BookingService $bookingService){

        $this->orderService = $orderService;
        $this->bookingService = $bookingService;
    }

    public function getUserId($currentUser){

        return User::where('username',$currentUser)->first();

    }


    public function getUserDetail($userId){
        //todo 通过session 获取用户信息
        $userDetail['stable']    = User::where('id',$userId)->first();
        $userDetail['detail']  = UserProfile::where('user_id',$userId)->first();
        $userDetail['avatar']  = UserImage::where(['user_id' => $userId,'type' => 1])->first();

        return $userDetail;
    }

    public function getAllOrders($userId)
    {
        $orders =  Orders::where('user_id',$userId)->select('order_sn')->get();

        foreach($orders as $order)
        {
            $order->detail = $this->orderService->getOrderDetail($order->order_sn);

        }
        return $orders;
    }

    //保存资料
    public function saveProfile(Request $request)
    {
        $userName = $request->input('userName');
        $email = $request->input('email');
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        $signature = $request->input('signature');

        //当前用户
        $currentUser = session('currentUser');
        $UserInfo = $this->getUserId($currentUser);
        //todo
        $profile = UserProfile::where('user_id',$UserInfo->id)->first();
        if($profile == null)
        {
            $profile  = new UserProfile;

            $profile->user_id     = $UserInfo->id;
            $profile->user_name   = $userName;
            $profile->email       = $email;
            $profile->birth_year  = $year;
            $profile->birth_month = $month;
            $profile->birth_day   = $day;
            $profile->signature   = $signature;

            return $profile->save();
        }else{
            //已有数据
            return UserProfile::where('user_id',$UserInfo->id)->update([
                'user_name'   => $userName,
                'email'       => $email,
                'birth_year'  => $year,
                'birth_month' => $month,
                'birth_day'   => $day,
                'signature'   => $signature,
            ]);
        }

    }


    //获取搜藏列表
    public function getUserCollections($userId)
    {
        $collectionList = UserCollection::where('user_id',$userId)->get();
        foreach($collectionList as $collection)
        {
            $collection->hotelDetail = DB::table('hotel')->join('hotel_image','hotel.id','=','hotel_image.hotel_id')
                ->join('address','hotel.address_id','=','address.id')
                ->join('city','address.city_code','=','city.code')
                ->join('province','address.province_code','=','province.code')
                ->join('room','room.hotel_id','=','hotel.id')
                ->join('user_collection','hotel.id','=','user_collection.hotel_id')
                ->where('hotel_image.is_cover',2)
                ->where('user_collection.hotel_id',$collection->hotel_id)
                ->selectRaw('hotel.*,province.province_name,province.province_name_en,city.city_name,city.city_name_en,address.detail,address.detail_en,hotel_image.link, min(room.rack_rate) as priceFrom')->first();
        }

        return $collectionList;

    }

    //添加到收藏
    public function addToCollection(Request $request)
    {
        $hotel = Hotel::where('code',$request->input('hotel'))->first();

        if($hotel != null)
        {
            //当前用户
            $currentUser = session('currentUser');
            $UserInfo = $this->getUserId($currentUser);
            $collection = UserCollection::where(['user_id'=>$UserInfo->id,'hotel_id'=>$hotel->id])->first();

            //如果记录存在, 那就删除记录
            if($collection != null)
            {
                return $collection->delete();
            }
            //如果不存在,新建一条记录
            else{
                $collection = new UserCollection();
                $collection->user_id  = $UserInfo->id;
                $collection->hotel_id = $hotel->id;
                return  $collection->save();
            }
        }
        else{
            return false;
        }

    }

    //删除收藏
    public function removeFromCollection(Request $request)
    {
        $hotel = Hotel::where('code',$request->input('hotel'))->first();

        if($hotel != null)
        {
            //当前用户
            $currentUser = session('currentUser');
            $UserInfo = $this->getUserId($currentUser);
            $collection = UserCollection::where(['user_id'=>$UserInfo->id,'hotel_id'=>$hotel->id])->first();

            //如果记录存在, 那就删除记录
            if($collection != null)
            {
                return $collection->delete();
            }
            return true;
        }
        else{
            return false;
        }

    }


    public function getAccountDetail($userId)
    {
        //todo session 获取id

        

    }

}


?>