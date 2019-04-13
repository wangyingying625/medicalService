<?php

namespace App\Http\Controllers\Wechat;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nexmo\User\User;

class IndicatorController extends Controller
{
    //
    public function upload(Request $request)
    {
        $file = $request->file('image');
        $openId = $request->input('openId');
        $user = User::where('openId',$openId)->first();
        $name = $file->store('upload', 'public');
        $image = new Image();
        $image->name = $name;
        $image->user_id = $user->id;
        $image->save();
        return $image;

    }
}
