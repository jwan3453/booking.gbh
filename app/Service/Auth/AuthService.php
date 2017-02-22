<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 16/12/16
 * Time: 上午8:35
 */
namespace App\Service\Auth;

use Illuminate\Support\Facades\Session;
use PDO;
use Faker\Provider\Uuid;
use App\User;
use App\Http\Requests;
use App\Tool\MessageResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
Use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;


use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;


class AuthService{

    /**
     *
     * 登录验证
     *
     */
    public function checkLogin($username, $password = null){

        $where = ['username' => $username];
        $the_data = DB::table('users')->where($where)->first();


        $result = new MessageResult();
        if (count($the_data) < 1) {
            $result->statusCode = 1;
            $result->statusMsg  = '用户名不存在';
        }
        else if (isset($password) && Hash::check($password, $the_data->password)) {

            $result->statusCode = 2;

        }else{
            $result->statusCode = 3;
            $result->statusMsg  = '密码不正确';
        }

        return $result;
    }
    //存入Session
    public function loginSession($username = '') {

        session(['currentUser' => $username]);

    }
    //修改密码的session
    public function changeSession($admin = ''){
        $session = session(['changeUser' => $admin]);
        return $session;
    }
    //修改密码方式
    public function meansSession($admin = ''){
        $session = session(['means' => $admin]);
        return $session;
    }
    //退出
    public function _logout(){
        session()->forget('currentUser');
    }

    /**
     *
     * 注册验证
     *
    */

    //查询数据库有无重复数据
    public function checkRepeatData(Request $request){

        $user = $request->input('user');

        //查询数据库有无重复数据
        $copy_username = DB::table('users')->where('username','=',$user['username'])->get();
        $copy_email = DB::table('users')->where('email','=',$user['email'])->get();
        $copy_phone = DB::table('users')->where('phone','=',$user['phone'])->get();

        $res = new MessageResult();
        $valid = true;
        if($copy_username){
            $valid= false;
            $res->statusCode =1;
            $res->StatusMsg = '用户名已有';
        }
        if($copy_email){
            $valid= false;
            $res->statusCode =2;
            $res->StatusMsg = '邮箱重复';
        }
        if($copy_phone){
            $valid= false;
            $res->statusCode =3;
            $res->StatusMsg = '手机号码重复';
        }


        if($valid == false){
            return $res;
        }
    }

    //存入数据库
    public function storage(Request $request){

        $user = $request->input('user');
        $storageRes = User::create([
            'username' => $user['username'],
            'email'    => $user['email'],
            'phone'    => $user['phone'],
            'password' => bcrypt($user['password']),
        ]);
        if($storageRes){
            return $storageRes;
        }
    }

    //检查手机号码有无重复
    public function checkRepeatMobile(){

        //返回1表示有重复数据;
        $mobile = $_POST['mobile'];
        $copy_phone = DB::table('users')->where('phone','=',$mobile)->get();
        if($copy_phone){
            return 1;
        }else{
            return 2;
        }
    }

    //发送验证码:发送成功返回1
    public function smsCode(){

        $mobile = $_POST['mobile'];

        $config = [
            'app_key'    => '23644303',
            'app_secret' => 'ece27eb39a7a4b5d2a4d681e27867bfd',
        ];

        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
        $number = rand(100000, 999999);

        //存储验证码到数据库以便验证

        $req->setRecNum($mobile)
            ->setSmsParam([
                'number' => $number
            ])
            ->setSmsFreeSignName('精品酒店')         //签名名称
            ->setSmsTemplateCode('SMS_47875171');  //模板ID

        $resp = $client->execute($req);
        if($resp) {
            //发送成功
            DB::insert('insert into SMS_Log (SMS_code,SMS_mobile) values (?,?)',array($number,$mobile));
            return 1;
        }
    }

    //检查验证码:1表示成功;2表示错误
    public function checkErrorCode(Request $request){

        $mobile = $request->input('mobile');
        $code = $request->input('code');
        if($code != null){
            $sms_code = DB::table('SMS_Log')->where('SMS_code','=',$code)->first();
            if($sms_code != null){
                $sms_res['SMS_mobile'] = $mobile;
                return 1;
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }


    //单一检查是否有重复用户名
    public function checkRepeatUser(){
        //返回1表示有重复数据;
        $username = $_POST['username'];
        $copy_phone = DB::table('users')->where('username','=',$username)->get();
        if($copy_phone){
            return 1;
        }else{
            return 2;
        }
    }
    //单一检查是否有重复邮箱
    public function checkEmail(){
        //返回1表示有重复数据;
        $email = $_POST['email'];
        $copy_phone = DB::table('users')->where('email','=',$email)->get();
        if($copy_phone){
            return 1;
        }else{
            return 2;
        }
    }


    //修改密码部分

    //查询手机号对应的用户名:
    public function searchUser(){

        $mobile = $_POST['mobile'];
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $Res = DB::table('users')->where('phone','=',$mobile)->first();
        return $Res;


    }

    //发送邮件
    public function sendEmail(){

        date_default_timezone_set('Etc/GMT-8'); //时区设置
        $nowTime = date("y-m-d h:i:s",time());
        $username=  $_POST['username'];
        $toEmail = $_POST['email'];
        $addressKey = Uuid::uuid();
        $Message = "尊敬的璞伦酒店用户:".$username."

        您好!
        您的账户在:".$nowTime."申请了修改密码操作,请确认是您本人的操作。
        点击以下地址修改您的密码:  http://c.com/jumpAddress/".$addressKey."(30分钟后无效)
        (如果无法点击该URL链接地址，请将它复制并粘帖到浏览器的地址输入框，然后单击回车即可。)
        如有任何问题,请发送邮件到:booking@gbhchina.com 。



        此为系统消息,请勿回复。";

        $data = ['email'=>$toEmail, 'Message'=>$Message];

        //信息记录到数据库:
        DB::insert('insert into PWD_Log (username,email,addressKey,updated_at) values (?,?,?,?)',array($username,$toEmail,$addressKey,$nowTime));


        return Mail::raw($data['Message'],function($message) use ($data){
            $message->from('booking@gbhchina.com');
            $message->to($data['email'])->subject('来自gbhchina.com的验证邮件');
        });



    }
    //判断修改密码地址
    public function searchAddress($key){
        date_default_timezone_set('Etc/GMT-8');  //设置时区
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $addressRes = DB::table('PWD_Log')->where('addressKey','=',$key)->first();
        if($addressRes){
            //判断地址是否过期
            $LogTime = strtotime($addressRes['updated_at']);
            $nowTime = strtotime(date("y-m-d h:i:s",time()));
            $diffTime = $nowTime-$LogTime;
            $leftHour = floor($diffTime/3600);  //计算小时
            $time = floor(($diffTime-$leftHour*3600)/60);

            $diffSecond = $leftHour*60+$time;   //计算分钟
            if($diffSecond<30){
                return $addressRes['username'];
            }else{

                return "error";

            }
        }

    }

    //修改密码:1修改成功
    public function changePassword(Request $request){
        $username = $request->input('username');
        $password = bcrypt($request->input('password'));
        $meansSession = $request->input('means');
        date_default_timezone_set('Etc/GMT-8');
        $nowTime = date("y-m-d h:i:s",time());
        $means = "用户".$username."在".$nowTime."".$meansSession;

        $Res = DB::table('users')->where('username','=',$username)->update(['password'=>$password,'changePasswordHistory'=>$means]);
        if($Res){
            return 1;
        }else{
            return 2;
        }

    }

}