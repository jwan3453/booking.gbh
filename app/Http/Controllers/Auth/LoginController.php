<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Service\Auth\AuthService;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{

    private $authService;

    public function __construct(AuthService $authService){

        $this->authService = $authService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->isMethod('POST')) {

            $username = $request->input('username');
            $password = $request->input('password');


            $userRes = $this->authService->checkLogin($username,$password);

            if($userRes ==2){
                //验证成功,存入session
                $value = $this->authService->loginSession($username);

                //判断是否选择记住用户名
                if($request->input('remember')){
                    //对用户名进行加密
                    $usernameKey = base64_encode($username);
                    setcookie("username", $usernameKey, time()+3600*24);
                }else{
                    setcookie("username", $username, time()-3600);  //清除COOKIE
                }

                return redirect('/');
            }
            else{
                return $userRes;
//                return back()->withInput()->withErrors('用户名或密码错误');
            }

        }else{
            if(Cookie::has('username')){
                //对cookie解密:
                $usernameKey = Cookie::get('username');
                $usernameValue = base64_decode($usernameKey);
                return view('auth.login')->with(Cookie::get('username'))->with('username',$usernameValue);
            }else{
                return view('auth.login');
            }

        }

    }

    public function logout(){
        $this->authService->_logout();
        return redirect('/');
    }
    //注册成功
    public function regSuccess(){
        return redirect('/');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     * 注册验证
     *
     */
    public function register(Request $request)
    {
        if($request->isMethod('POST')){

            //查询数据库有无重复数据
            $repeatRes = $this->authService->checkRepeatData($request);
            if(!$repeatRes){

                //符合要求,存入数据库
                $this->authService->storage($request);
            }else{
                return response( $repeatRes->toJson());
            }

        }else{
            return view('auth.register');
        }
    }

    //验证邮箱
    public function checkEmail(){
        $emailRes = $this->authService->checkEmail();
        return $emailRes;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * 发送验证码
     *
     */
    public function sendCode()
    {

        $smsCode = $this->authService->smsCode();
        if($smsCode == 1){
            return 1;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 手机号验证:返回1表示有重复数据,返回2表示验证成功
     *
     */

    public function checkMobile()
    {
        //返回1表示有重复数据,返回2表示验证成功;
        $mobile = $this->authService->checkRepeatMobile();
        if($mobile == 1){
            return 1;
        }else{
            return 2;
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * 验证码:返回1表示验证成功.
     *
     */

    public function checkCode(Request $request)
    {

        $checkMobileRes = $this->authService->checkErrorCode($request);
        if($checkMobileRes == 1){
            return 1;
        }else{
            return 2;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * 分部验证用户名:返回1则有重复数据
     *
     */
    public function checkUser()
    {
        //返回1表示有重复数据,返回2表示验证成功;
        $user = $this->authService->checkRepeatUser();
        if($user == 1){
            return 1;
        }else{

            return 2;
        }
    }
    public function userSession(){

        //返回1表示有重复数据,返回2表示验证成功;
        $user = $this->authService->checkRepeatUser();
        if($user == 1){
            return 1;
        }else{
            //验证后存值给Session
            $username = $_POST['username'];
            $this->authService->loginSession($username);
            return 2;
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *
     * 发送邮箱:1表示成功
     *
     */
    public function sendMessage()
    {


            $sendEmail = $this->authService->sendEmail();
            if($sendEmail){

                return 1;
            }else{
                return 2;
            }


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     *
     * 修改密码部分
     *
     */
    //通过手机验证进入页面
    public function searchMobile(){
        $Res = $this->authService->searchUser();
        if($Res){
            $value = $Res['username'];
            //放入session
            $this->authService->changeSession($value);
            $means = "通过手机修改密码";
            $this->authService->meansSession($means);

            return 1;

        }else{
            return view('errors.404');
        }
    }

    public function passwordByMobile(){

        return view('auth.rewrite');

    }

    //通过邮箱进入页面:验证页面是否有效
    public function jumpAddress($key){

        $searchKey = $this->authService->searchAddress($key);
        if($searchKey!="error"){
            //存入session
            $sessionValue = $this->authService->changeSession($searchKey);
            $means = "通过邮箱修改密码";
            $this->authService->meansSession($means);
            return view('auth.rewrite')->with($sessionValue);
        }else{
            return view('errors.404');
        }
    }
    //修改密码
    public function changePassword(Request $request){
        if($request->isMethod('POST')){
            //修改数据库数据

            $changeRes = $this->authService->changePassword($request);
            if($changeRes == 1){
                return redirect('/auth/login');

            }
            else{
                return back()->withInput()->withErrors('修改失败');
            }
        }

    }

}
