<?php

namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password','phone','changePasswordHistory'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * 检查用户是否与数据库中匹配
     * @param $username 用户名
     * @param null $password 密码如果为空，则只检查数据库中是否存在该用户名
     * @return bool
     */
//    static function _check($username, $password = null) {
//        $where = ['username' => $username];
//        $the_data = self::where($where)->first();
//
//        if (count($the_data) < 1) {
//            return false;
//        }
//        if (isset($password) && Hash::check($password, $the_data->password)) {
//            $ret = $the_data->toArray();
//            unset($ret['password']);
////            session(['currentUser'=>$ret]);
//            return $ret;
//        }
//        return false;
//    }
//    /**
//     * 判断是否登录
//     * @return bool
//     */
//    static function _is_login() {
//        return session('currentUser');
//    }
//    /**
//     * 登录
//     * @param string $admin 要存储的值
//     */
//    static function _login($admin = '') {
//        $session = session(['currentUser' => $admin]);
//        return $session;
//    }
//    /**
//     * 登出
//     */
//    static function _logout() {
//        session()->forget('currentUser');
//    }

}
