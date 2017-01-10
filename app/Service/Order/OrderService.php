<?php


namespace App\Service\Order;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Address;
use App\Models\HotelImage;
use App\Models\Orders;
use App\Service\Booking\BookingService;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

use App\Tool\Pay\Wechatpay\WxPayUnifiedOrder;
use App\Tool\Pay\Wechatpay\WxPayApi;

use App\Tool\Pay\Alipay\alipay;
use App\Tool\Pay\Alipay\alipay\lib;
;
/**
 *
 */
class OrderService {

    //获取推荐的酒店
    public function getRoomDetail($hotelId, $roomId, $checkInDate, $checkOutDate)
    {
        $offerDetail=[];

        //获取酒店基本信息
        $hotelDetail =  Hotel::where('id',$hotelId)->firstOrFail();
        $hotelDetail->address = Address::where('id',$hotelDetail->address_id)->first();
        if($hotelDetail->address != null)
        {
            $hotelDetail->province  = (new BookingService())->getAdressInfo('province',$hotelDetail->address->province_code,$hotelDetail->address->type);
            $hotelDetail->city  = (new BookingService())->getAdressInfo('city',$hotelDetail->address->city_code,$hotelDetail->address->type);
            $hotelDetail->district  = (new BookingService())->getAdressInfo('district',$hotelDetail->address->district_code,$hotelDetail->address->type);
        }


        //获取房间基本信息
        $roomDetail = Room::where(['id'=>$roomId])->firstOrFail();
        $roomDetail->imageLink=HotelImage::where(['section_id'=> $roomDetail->id,'hotel_id' => $hotelId,'type'=>2])->first()->link;

        //获取房间均价
        $result = $this->getOfferPrice($hotelId,$roomId, $checkInDate, $checkOutDate);



        $offerDetail['hotel'] = $hotelDetail;
        $offerDetail['room'] = $roomDetail;


        $offerDetail['checkInDate'] = $checkInDate;
        $offerDetail['checkOutDate'] =     $checkOutDate;
        $dateDiff = (new BookingService())->diffBetweenTwoDays($checkInDate, $checkOutDate) ;

            $offerDetail['averagePrice'] = $result['averagePrice'];
            $offerDetail['totalAmount'] = $result['averagePrice'] * $dateDiff;
            $offerDetail['dateDiff'] = $dateDiff;
            $offerDetail['maxBookingNum'] = $result['maxBookingNum'];


        return $offerDetail;
    }



    //
    public function searchPriceByDate($hotelId,$roomId,$checkInDate,$checkOutDate,$numOfRoom)
    {


        $offerDetail=[];
        $result= $this->getOfferPrice($hotelId,$roomId,$checkInDate,$checkOutDate,$numOfRoom);
        $dateDiff = (new BookingService())->diffBetweenTwoDays($checkInDate, $checkOutDate) ;


            $totalAmount =$dateDiff * (int)$numOfRoom *  $result['averagePrice'];
            $offerDetail['averagePrice'] = $result['averagePrice'];
            $offerDetail['maxBookingNum'] =  $result['maxBookingNum'];

            $offerDetail['dateDiff'] = $dateDiff;
            $offerDetail['exceedNum'] = $result['exceedNum'];
            if($offerDetail['exceedNum'] > 0 )
            {
                $offerDetail['totalAmount']  = $totalAmount;
            }
            else{
                $offerDetail['totalAmount'] = $dateDiff * (int)$result['maxBookingNum'] *  $result['averagePrice'];
            }

        return $offerDetail;
    }



    //获取房价
    public function getOfferPrice($hotelId,$roomId, $checkInDate, $checkOutDate, $numOfRoom = 1)
    {


        $result = [];

        $checkOutDate = date('Y-m-d',strtotime('+1 d',strtotime($checkOutDate)));
        //到店日期和离店日期的间隔
        $dateDiff = (new BookingService())->diffBetweenTwoDays($checkInDate, $checkOutDate)+1;

        //获取房态列表
        $roomStatus  =DB::table('room_status') ->whereBetween('date', array($checkInDate, $checkOutDate))->where('room_id',$roomId)->get();


        //获取房价列表
        $roomPrice = DB::table('room_price') ->whereBetween('date', array($checkInDate, $checkOutDate))->where('room_id',$roomId)->get();


        $hasRoomCount = 0;
        $avgPrice = 0;
        $maxBookingNum = 0;
        $tmpIndex = 0;
        foreach($roomStatus as $status)
        {

            //现付
            if($tmpIndex == 0)
            {
                $maxBookingNum = $status->num_of_blocked_room - $status->num_of_sold_room;
            }
            if( $status->room_status == 1  )
            {
                if(($status->num_of_blocked_room - $status->num_of_sold_room) < $maxBookingNum )
                {
                    //得到时间内可以订房的最大数量
                    $maxBookingNum = $status->num_of_blocked_room - $status->num_of_sold_room;

                }
                    $hasRoomCount++;
            }
                //预付

            $tmpIndex++;
        }



        foreach($roomPrice  as $price)
        {
            $avgPrice += $price->rate;
        }


        $result['averagePrice'] = ($avgPrice/$dateDiff);
        $result['maxBookingNum'] = $maxBookingNum;


        //判断所需房型是否超出了实际房态
        if($maxBookingNum >=$numOfRoom )//有房
        {
            $result['exceedNum'] = 0 ;
        }
        else{
            $result['exceedNum'] = ( $numOfRoom - $maxBookingNum);
        }
        return $result;

    }


    //创建新订单
    public function createOrder(Request $request)
    {


        $hotelId = $request->input('hotel');
        $roomId = $request->input('room');


        $checkInDate = $request->input('checkInDate');
        $checkOutDate = $request->input('checkOutDate');

        $maxBookingNum  = $request->input('maxBookingNum');
        $roomNum = $request->input('roomNum');

        $guestInfoList =$request->input('guestInfo');

        $contactPhone = $request->input('contactPhone');
        $contactEmail = $request->input('contactEmail');


        //检查订单数据合法性
        $totalAmount = 0;
        $average_price = 0;


        //新建订单到数据库
        $newOrder = new Orders();
        $newOrder->order_sn =  uniqid();
        $newOrder->hotel_id = $hotelId;
        $newOrder->room_id = $roomId;

        $newOrder->user_id = '';
        $newOrder->num_of_room = $roomNum;

        $guestList= '';
        foreach($guestInfoList as $guestInfo)
        {
            $guestList = $guestList.$guestInfo.'|';
        }
        $newOrder->guest_list = $guestList;
        $newOrder->contact_phone = $contactPhone;
        $newOrder->contact_email = $contactEmail;

        $newOrder->check_in_date = $checkInDate;
        $newOrder->check_out_date = $checkOutDate;

        $newOrder->average_price =$average_price;
        $newOrder->total_amount = $totalAmount;

        $newOrder->pay_status = 0;
        $newOrder->payment_type = 0;

        $newOrder->coupon_code =0;

        $newOrder->is_guarantee = 0;
        $newOrder->order_status = 0;




        if($newOrder->save())
        {
            return $newOrder;
        }
        return null;
    }



    public function getOrderDetail($orderSn)
    {
        $order = Orders::where('order_sn',$orderSn)->first();

        //检查订单时效,如果超过时间还未支付
        if($order != null)
        {
            //获取酒店基本信息 //todo 处理错误
            $hotelDetail =  Hotel::where('id',$order->hotel_id)->firstOrFail();

            $hotelDetail->address = Address::where('id',$hotelDetail->address_id)->first();
            if($hotelDetail->address != null)
            {
                $hotelDetail->province  = (new BookingService())->getAdressInfo('province',$hotelDetail->address->province_code,$hotelDetail->address->type);
                $hotelDetail->city  = (new BookingService())->getAdressInfo('city',$hotelDetail->address->city_code,$hotelDetail->address->type);
                $hotelDetail->district  = (new BookingService())->getAdressInfo('district',$hotelDetail->address->district_code,$hotelDetail->address->type);
            }


            //获取房间基本信息
            $roomDetail = Room::where(['id'=>$order->room_id])->firstOrFail();
            $roomDetail->imageLink=HotelImage::where(['section_id'=> $roomDetail->id,'hotel_id' => $order->hotel_id,'type'=>2])->first()->link;


            $order->hotelDetail = $hotelDetail;
            $order->roomDetail  =$roomDetail;


        }
        $order->dateDiff = (new BookingService())->diffBetweenTwoDays($order->check_in_date, $order->check_out_date);

        return $order;
    }

    //生成支付二维码
    public function generatePayQrCode($orderSn)
    {

        //获取订单详情
        $orderDetail = Orders::where('order_sn',$orderSn)->firstOrFail();
        $hotelName = Hotel::where('id',$orderDetail->hotel_id)->select('name')->first();
        $roomName =  Room::where('id',$orderDetail->room_id)->select('room_name')->first();
        //todo 处理订单异常


        $totalAmount = $orderDetail->total_amount;
        $appid = Config::get('wechatpay.appid');
        $mch_id = Config::get('wechatpay.mch_id');
        $body = Config::get('wechatpay.body');
        $device_info = Config::get('wechatpay.device_info');
        $api_key = Config::get('wechatpay.api_key');
        $sign_type = Config::get('wechatpay.sign_type');
        $nonce_str = $this->getRandomString(32);
        $sign = $this->getSign($appid,$mch_id,$body,$device_info,$nonce_str,$api_key );



        $detail['cost_price'] = $totalAmount;
        $goods_detail = [];
        $goods_detail['goods_id'] =$orderDetail->hotel_id.'-'.$orderDetail->room_id;
        $goods_detail['goods_name'] = $hotelName->hotel_name.'-'.$roomName->room_name;
        $goods_detail['quantity'] = $orderDetail->num_of_room;
        $goods_detail['price']  = $orderDetail->average_price;
        $detail['goods_detail'] = $goods_detail;

        $attach = '测试数据';
        $out_trade_no = $this->getOurTradeNo();
        $fee_type=Config::get('wechatpay.fee_type');
        $total_fee = $totalAmount;

        $spbill_create_ip = $_SERVER['SERVER_ADDR'];

        $time_start = date("YmdHis");
        $time_expire = date("YmdHis", time() + 285000);
        $goods_tag = 'full-price';

        $notify_url = Config::get('wechatpay.notify_url');

        $trade_type =Config::get('wechatpay.trade_type');

        $product_id =$orderDetail->hotel_id.'-'.$orderDetail->room_id;

        $limit_pay = '';

        $data = json_encode($detail);





        $notify = new  WxPayApi();
        $input = new WxPayUnifiedOrder();
        $input->SetBody(Config::get('wechatpay.body'));
        $input->SetAttach("测试数据");
        $input->SetOut_trade_no(Config::get('wechatpay.mch_id').date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start($time_start);
        $input->SetTime_expire($time_expire);
        $input->SetGoods_tag("test");
        $input->SetNotify_url(Config::get('wechatpay.notify_url'));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");

        $input->SetAppid($appid);//公众账号ID
        $input->SetMch_id($mch_id);//商户号
        $input->SetSpbill_create_ip('1.1.1.1');//终端ip
        //$inputObj->SetSpbill_create_ip("1.1.1.1");
        $input->SetNonce_str($nonce_str);//随机字符串

        //签名
        $input->SetSign();

        //发起请求，获取支付url
        $result = $notify->unifiedOrder($input);

        dd($result);
        if($result['return_code'] === 'FAIL')
        {
            //todo 获取微信支付状态失败 写入数据库 或者log

        }
        else{
            $result['totalAmount'] = 1299;
        }


        return $result;


    }


    //生成随机数
    public function getRandomString($length)
    {
        $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for($i=0;$i<$length;$i++)
        {
            $key .= $str{mt_rand(0,32)};    //生成php随机数
        }
         return $key;
    }


    //生成签名
    public function getSign($appid,$mch_id,$body,$device_info,$nonce_str,$api_key )
    {
        $singString  = 'appid='.$appid.'&body='.$body.'&device_info='.$device_info.'&mch_id='.$mch_id.'&nonce_str='.$nonce_str;
        $signString = $singString.'&key='.$api_key;
        $signString = strtoupper(md5($signString));
        return  $signString;
    }

    //生成商户订单号
    public function getOurTradeNo()
    {
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }







    /////////////////////支付宝支付/////////////////////

    public function processAlipay($orderSn)
    {
        //获取订单详情
        $orderDetail = Orders::where('order_sn',$orderSn)->firstOrFail();
        $hotelName = Hotel::where('id',$orderDetail->hotel_id)->select('name')->first();
        $roomName =  Room::where('id',$orderDetail->room_id)->select('room_name')->first();
        //todo 处理订单异常


        $out_trade_no = $orderDetail->order_sn;

        //订单名称，必填
        $subject = $hotelName->name.'-'.$roomName->room_name;

        //付款金额，必填
        $total_fee = 0.01; //$orderDetail->total_amount

        //商品描述，可空
        $body = '全球精品酒店订单支付';





        /************************************************************/

//构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => Config::get('alipay.service'),
            "partner"       => Config::get('alipay.partner'),
            "seller_id"  => Config::get('alipay.seller_id'),
            "payment_type"	=> Config::get('alipay.payment_type'),
            "notify_url"	=> Config::get('alipay.notify_url'),
            "return_url"	=> Config::get('alipay.return_url'),

            "anti_phishing_key"=>Config::get('alipay.anti_phishing_key'),
            "exter_invoke_ip"=>Config::get('alipay.exter_invoke_ip'),
            "out_trade_no"	=>$out_trade_no,
            "subject"	=>$subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "_input_charset"	=> Config::get('alipay.input_charset')
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
            //如"参数名"=>"参数值"

        );


        $alipaySubmit = new \App\Tool\Pay\Alipay\alipay\lib\AlipaySubmit( Config::get('alipay.aliconfig'));
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");

        echo $html_text;


    }
}


?>