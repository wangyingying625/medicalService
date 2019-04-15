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
        $members = User::where('family_id',$family->id)->where('status','member')->get();
        $members[] = User::where('family_id',$family->id)->where('status','admin')->first();
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

    public function apply(Request $request){
        $familyName = $request -> input('family_name');
        $family = Family::where('name',$familyName)->get();
        if (!$family->count()){
            return ['status'=>false,'message'=>"不存在该家庭，请确认填写是否有误"];
        }else{
            $family = $family[0];
        }
        $openId = $request->input('openId');
        $user = User::where('openId',$openId)->first();
        if ($family && $user->status == 'no'){
            $user->status = 'joining';
            $user -> family_id = $family->id;
            $user->save();
            return ['status'=>true,'message'=>"申请成功,请等待管理员审核"];
        }

    }

    public function quit(Request $request){
        $openId = $request->input('openId');
        $user = User::where('openId',$openId)->first();
        $user->update(['status'=>'no','family_id'=>0]);
        return ['status'=>true];
    }

    public function manage(Request $request){
        $openId = $request->input('openId');
        $user = User::where('openId',$openId)->first();
//        $familyId = $user -> family_id;
        //遍历family_id=管理员所在家庭id用户的status字段,如果为waiting,则进行处理
        //进行遍历
        $NewMembers = User::where('status','joining')->where('family_id',$user->family_id)->get();
        foreach ($NewMembers as $member){
            $member['msg'] = $member['name']."申请加入家庭";
        }
        return $NewMembers;
    }

    public function accept(Request $request){

        $userId = $request->input('user_id');
        $user = User::find($userId);
        $user->update(['status'=>'member']);
        return ['status'=>true];
    }

    public function del(Request $request){
        //判断是否为管理员身份
        $userId = $request->input('user_id');
        $user = User::find($userId);
        $status = $user -> update([
            'family_id' => 0,
            'status' => 'no'
        ]);

        return ['status'=>true];

//        return $status?"删除成功":"删除失败";
    }
}
