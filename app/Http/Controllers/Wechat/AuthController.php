<?php

namespace App\Http\Controllers\Wechat;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Iwanli\Wxxcx\Wxxcx;


class AuthController extends Controller
{
    //
    protected $wxxcx;

    function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * 小程序登录获取用户信息
     * @author 晚黎
     * @date   2017-05-27T14:37:08+0800
     * @return [type]                   [description]
     */
    public function getWxUserInfo()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
//        $encryptedData = request('encryptedData', '');
//        $iv = request('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        //获取解密后的用户信息
        $openId = $userInfo['openid'];
//        $user_profile = $this->wxxcx->getUserInfo($encryptedData, $iv);
        $user = User::where('openId', $openId)->first();
        $result = [];
        $result['openId'] = $openId;
        if ($user) {
            $result['status']=true;
            $result['user'] = $user;
        } else {
            $result['status'] = false;
        }
        return $result;
//        return $this->wxxcx->getUserInfo($encryptedData, $iv);
    }


    public function register(Request $request){
        $info = $request->input();
        $info['password'] = bcrypt($info['password']);
        $user  =  User::create($info);
        return $user;
    }

    public function binding(Request $request){
        $username = request()->get('name');
        $password = request()->get('password');
        $openId = request()->get('openId');
        $result = [];
        //验证账号密码，postdata数据key为数据库存储字段名。
        $postdata = ['name' => $username, 'password'=>$password];
        $ret = Auth::attempt($postdata);
//        var_dump($ret);
        if($ret){
            $user = User::where('name',$username)->first();
            $user->openId = $openId;
            $user->save();
            $result['user'] = $user;
            $result['status'] = true;
            return $result;
        }else{
            $result['status'] = false;
            return $result;

        }
    }
}
