<?php

namespace App\Http\Controllers\Wechat;

use App\Family;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FamilyController extends Controller
{
    //
    public function createFamily(Request $request){
        $openID = $request->input('openId');
        $user = User::where('openId',$openID)->first();
//        $user = Auth::user();
        //存储家庭名
        $family = Family::create($request -> all());
        //获取当前存储的家庭id
        //为该家庭创建者添加该家庭的id
        //为该家庭创建者更新status字段
        $user -> family_id = $family->id;
        $user -> status = 'admin';
        $user->save();
        return redirect('/family/info/'.$family->id);
    }
}
