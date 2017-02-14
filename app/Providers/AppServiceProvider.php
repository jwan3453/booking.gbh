<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Service\Booking\BookingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*',function($view){
            $bookingService = new BookingService();

            //判断是否登录
            $currentUser = session('currentUser');
            if($currentUser){
                //查询用户的id
                $userInfo  = $bookingService->getUserInfo($currentUser);
                //获取头像信息

                $userImage = $bookingService->getUserImage($userInfo->id);

            }else{
                $userImage = '';
                $userInfo  = '';
            }

            $view->with(['userImage' => $userImage ,'userInfo' => $userInfo]);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
