<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\Api\UserRequest;


class UserController extends Controller
{
//返回用户列表
    public function index()
    {
        //3个用户为一页
        $users = User::paginate(3);
        return $this->success($users);
    }


    //用户注册
    public function store(UserRequest $request)
    {
        User::create($request->all());
        return $this->setStatusCode(201)->success('用户注册成功');

    }
//修改资料
    public function edit(Request $request)
    {
        $user = Auth::guard('api')->user();
        $status = $user->update(json_decode($request->input("user"),true));
        $user = Auth::guard('api')->user();
        return $this->success(($user));
    }
    //用户登录
    public function login(Request $request)
    {
        $token = Auth::guard('api')->attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('账号或密码错误', 400);
    }

//用户退出
    public function logout()
    {
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }

//返回当前登录用户信息
    public function info()
    {
        $user = Auth::guard('api')->user();
        return $this->success(($user));
    }
}
