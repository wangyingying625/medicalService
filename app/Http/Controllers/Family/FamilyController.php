<?php

namespace App\Http\Controllers\Family;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Family;
use App\User;
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
        $user = Auth::user();
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

    /**
     * 成员申请加入家庭
     */
    public function apply(Request $request){
        $familyName = $request -> input('familyName');
        $family = Family::where('name',$familyName);
        $user = Auth::user();
        if ($family && $user->status == ''){
            $user->status = 'joining';
            $user -> family_id = $family->id;
            $user->save();
        }
    }

    public function add(Request $request){
        return view('familyAdd');
    }

    public function accept(Request $request){
        $user = Auth::user();
        $user->update(['status'=>'member']);
        return redirect('/family/info/'.$user->family_id);
    }

    /**
     * 向管理员显示申请加入家庭的人
     */
    public function showApply(Request $request){
        //判断是否为管理员身份
        $userId = $request -> session() -> get('id');
        $familyId = $request -> session() -> get('family_id');
        $permission = User::where('id',$userId) -> where('family_id',$familyId) -> get('status');
        if($permission != 'admin'){
            return;
        }

        //遍历family_id=管理员所在家庭id用户的status字段,如果为waiting,则进行处理
        //进行遍历
        $count = User::all() -> count();
        $data = User::all() -> toArray();
        $waitIdArr = array();
        //获取status为waiting的用户,并将其id加入waitIdArr中
        for($i=0;$i<$count;$i++){
           if($data[$i]['status'] == 'status' && $data[$i]['family_id'] == $familyId)
               $waitIdArr[] = $data[$i]['id'];
        }
        foreach($waitIdArr as $apply)
        {
            echo User::where('id',$apply) -> get('name');
        }
    }

    /**
     * 管理员处理申请
     */
    public function dealWith(Request $request){
        //判断是否为管理员身份
        $userId = $request -> session() -> get('id');
        $familyId =$request -> session() -> get('family_id');
        $permission = User::where('id',$userId) -> where('family_id',$familyId) -> get('status');
        if($permission != 'admin'){
            return;
        }

        //根据动作进行操作（即同意[allow]或拒绝[refuse]）
        $action = $request -> input('action');
        if($action == 'allow'){
            User::where('id',$userId) -> update([
                'status' => 'member'
            ]);
        }
        elseif($action == 'refuse'){
            User::where('id',$userId) -> update([
                'family_id' => null,
                'status' => 'freeman'
            ]);
        }
        else
            return;
    }

    /**
     * 管理员邀请成员加入,略显复杂,暂时搁置
     */
    public function invite(Request $request){
        //判断是否为管理员身份
        $username = $request -> input('name');
        $familyId = $request -> input('familyId');
//        $permission = User::where('id',$userId) -> where('family_id',$familyId) -> get('status');
//        if($permission != 'admin'){
//            return;
//        }

        $user = User::where('name',$username)->get();
        $status = false;
        $reason = '';
//        var_dump($user);
        if ($user->isEmpty()){
            return "没有此用户";
        }
        $user = $user[0];
        $title = "邀请失败";
        if ($user->status=='no'){
            $status = User::where('name',$username)-> update([
                'family_id' => $familyId,
                'status'    => 'inviting'
            ]);
            $title = $status?"邀请成功":'邀请失败';
        }elseif ($user->status=='member' or $user->status=='admin' ){
            $reason = "该用户已加入家庭";
        }else{
            $reason = "该用户正在被邀请或申请加入其他家庭";
        }

        return view('location')->with(['title'=>$title,'message'=>$reason,'url'=>'/family/info/'.$familyId]);
//        return $status?"邀请成功":$reason;
    }


    /**
     * 管理员删除家庭成员
     */
    public function del(Request $request){
        //判断是否为管理员身份
        $userId = $request -> session() -> get('id');
        $familyId =$request -> session() -> get('family_id');
        $permission = User::where('id',$userId) -> where('family_id',$familyId) -> get('status');
        if($permission != 'admin'){
            return;
        }

        $user = User::find($userId);
        $status = $user -> where('id',$userId) -> where('family_id',$familyId)-> update([
            'family_id' => null
        ]);
        return $status?"删除成功":"删除失败";
    }

    public function showMembers(Request $request){
        $FamilyId = $request->route('FamilyId');
        $family = Family::find($FamilyId);
        $members = User::where('family_id',$family->id)->get();
        return view('family')->with(['members'=> $members, 'family' => $family]);
    }


}
