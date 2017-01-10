<?php


namespace App\Service\User;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Address;
use App\Models\HotelImage;
use App\Models\Orders;
use App\Service\Order\OrderService;
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

    public function __construct(OrderService $orderService){

        $this->orderService = $orderService;
    }




    public function getAllOrders()
    {
        $orders =  Orders::where('user_id',0)->select('order_sn')->get();

        foreach($orders as $order)
        {
            $order->detail = $this->orderService->getOrderDetail($order->order_sn);

        }
        return $orders;
    }

}


?>