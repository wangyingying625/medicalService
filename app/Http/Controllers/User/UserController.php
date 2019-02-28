<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    function info(Request $request){
        $user = User::find(Auth::id());
        return $user;
    }

    function update(Request $request){
        User::find(Auth::id())->update($request->all());
        return User::find(Auth::id());

    }

}
