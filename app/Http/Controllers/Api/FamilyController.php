<?php

namespace App\Http\Controllers\Api;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Family;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{


    /**
     * 个人信息中status共计有种状态
     * 1.no :该用户未加入任何家庭也未接到邀请
     * 2.admin： 该用户拥有家庭并且为管理员
     * 3.inviting： 该用户被邀请但未接受
     * 4.joining： 该用户申请加入但未同意
     * 5.member: 该用户已加入家庭并且为普通成员
     *
     */




    /**
     * 创建家庭,并将创建者身份初始化为管理员
     */
    public function createFamily(Request $request){
        $user = Auth::guard('api')->user();
        //存储家庭名
        $family = Family::create($request -> all());
        //获取当前存储的家庭id
        //为该家庭创建者添加该家庭的id
        //为该家庭创建者更新status字段
        $user -> family_id = $family->id;
        $user -> status = 'admin';
        $user->save();
        return $family;
    }
    public function showMembers(Request $request){
        $FamilyId = $request->input('family_id');
        $family = Family::find($FamilyId);
        $members = User::where('family_id',$family->id)->where('status','member')->get();
        $members[] = User::where('family_id',$family->id)->where('status','admin')->first();
//        array_unshift($members,$admin);
        foreach ($members as $member){
            $birthday = $member->birthday;
            $birthday = new DateTime($birthday);
            $now = new DateTime();
            $interval = $birthday->diff($now);
            $member['age'] = intval($interval->format('%Y'));
        }
        return ['members'=> $members, 'family' => $family];
    }
    /**
     * 成员申请加入家庭
     */
    public function apply(Request $request){
        $familyId = $request -> input('id');
        $family = Family::where('id',$familyId)->get();
        if (!$family->count()){
            return ['status'=>false,'message'=>"不存在该家庭，请确认填写是否有误"];
        }else{
            $family = $family[0];
        }
        $user = Auth::guard('api')->user();
        if ($family && $user->status == 'no'){
            $user->status = 'joining';
            $user -> family_id = $family->id;
            $user->save();
            return ['status'=>true,'message'=>"申请成功,请等待管理员审核"];
        }
        return ['status'=>false,'message'=>"您已申请加入此家庭,请勿重复申请"];

    }

    /**
     * 申请列表
     */
    public function applyList(Request $request){
        $user = Auth::guard('api')->user();
//        $familyId = $user -> family_id;
        //遍历family_id=管理员所在家庭id用户的status字段,如果为waiting,则进行处理
        //进行遍历
        $NewMembers = User::where('status','joining')->where('family_id',$user->family_id)->get();
        foreach ($NewMembers as $member){
            $member['msg'] = $member['name']."申请加入家庭";
        }
        return $NewMembers;
    }
    /**
     * 管理员同意申请
     */
    public function accept(Request $request){

        $userId = $request->input('user_id');
        $user = User::find($userId);
        $user->update(['status'=>'member']);
        return ['status'=>true];
    }
    /**
     * 管理员拒绝了申请
     */
    public function refuse(Request $request){
        //判断是否为管理员身份
        $userId = $request->input('user_id');
        $user = User::find($userId);
        $status = $user -> update([
            'family_id' => 0,
            'status' => 'no'
        ]);

        return ['status'=>true];

    }

    public function quitFamily(Request $request){
        $user = Auth::guard('api')->user();
        $user->update(['status'=>'no','family_id'=>0]);
        return ['status'=>true];
    }
    public function dissolveFamily(Request $request)
    {
        /*
         * 解散家庭
         */
        $user = Auth::guard('api')->user();
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

    /**
     * 管理员删除家庭成员
     */
    public function del(Request $request){
        $userId = $request->input('id');
        $user = User::find($userId);
        $status = $user -> update([
            'family_id' => 0,
            'status' => 'no'
        ]);

        return ['status'=>true];

//        return $status?"删除成功":"删除失败";
    }


}
