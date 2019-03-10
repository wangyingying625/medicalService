<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //

    function info(Request $request){
//        $user = User::find(Auth::id());
        return view('profile');
    }

    function update(Request $request){
        User::find(Auth::id())->update($request->all());
        return Redirect::to("/user/info");

    }

    function  change(Request $request){

        return view('changeProfile');
    }

}
