<?php

namespace App\Http\Controllers\Wechat;

use App\Family;
use App\User;
use DateTime;
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
        return $family;
//        return redirect('/family/info/'.$family->id);
    }

    public function showMembers(Request $request){
        $FamilyId = $request->input('family_id');
        $openId = $request->input('openId');
        $family = Family::find($FamilyId);
        $members = User::where('family_id',$family->id)->get();
        foreach ($members as $member){
            $birthday = $member->birthday;
            $birthday = new DateTime($birthday);
            $now = new DateTime();
            $interval = $birthday->diff($now);
            $member['age'] = intval($interval->format('%Y'));
        }
        return ['members'=> $members, 'family' => $family];
    }


    public function dissolveFamily(Request $request)
    {
        /*
         * TODO:解散家庭
         */
        $openId = $request->input('openId');
        $user = User::where('openId',$openId)->first();

        $userId = $user -> id;
        $familyId = $user -> family_id;
        $result = [];
        //如果该用户不是该家庭管理员
        if(User::where('id',$userId) -> value('status') != 'admin')
        {
            $result['status'] = false;
            $result['reason'] = '只有管理员才可以删除';
            return $result;
//            return view('location')->with(['title'=>'提示','message'=>'只有家庭管理员才有删除权限','url'=>'/family/add/']);
        }
        //将该家庭成员的status字段设置为no、并将family_id清空
        User::where('family_id',$familyId) -> update([
            'family_id' => NULL,
            'status' => 'no'
        ]);
        //删除该家庭
        if(Family::where('id',$familyId) -> delete())
        {
            $result['status'] = true;
        }
        else
        {
            $result['status'] = true;
        }
        return $result;
    }
}
