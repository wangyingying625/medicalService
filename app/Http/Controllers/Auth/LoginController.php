<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username()
    {
        return 'name';
    }


   // 退出后重定向到登录页
    public function loggedOut(Request $request)
    {
        return redirect('/login');
    }


    public function attemptLogin(Request $request)
    {
        $username = $request->input('name');
        $password = $request->input('password');

        // 验证用户名登录方式
        $usernameLogin = $this->guard()->attempt(
            ['name' => $username, 'password' => $password], $request->has('remember')
        );
        if ($usernameLogin) {
            return true;
        }


        // 验证邮箱登录方式
        $emailLogin = $this->guard()->attempt(
            ['email' => $username, 'password' => $password], $request->has('remember')
        );
        if ($emailLogin) {
            return true;
        }

        return false;
    }
}
