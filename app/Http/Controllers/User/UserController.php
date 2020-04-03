<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    function info(Request $request){
        return view('profile');
    }

    function update(Request $request){
        User::find(Auth::id())->update($request->all());
        return Redirect::to("/user/info");

    }

    function  change(Request $request){

        return view('changeProfile');
    }


    function upload(Request $request){
        $file = $request->file('image');
        $name = $file->store('avatar','public');
        $user = Auth::user();
        $user->avatar = '/storage/'.$name;
        $user->save();
        return $user;
    }
}
