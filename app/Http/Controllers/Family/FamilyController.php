<?php

namespace App\Http\Controllers\Family;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Family;
use App\User;

class FamilyController extends Controller
{
    //
    public function createFamily(Request $request){
        $family = new Family();
        $status = $family -> create($request -> only(['name']));
        return $status?"创建成功":"创建失败";
    }

    public function add(Request $request){
        $userId = $request -> input('id');
        $familyId = $request -> input('family_id');
        $user = \App\User::find($userId);
        $status = $user -> where('id',$userId) -> update([
            'family_id' => $familyId
        ]);
        return $status?"添加成功":"添加失败";
    }

    public function del(Request $request){
        $userId = $request -> input('id');
        $familyId = $request -> input('family_id');
        $user = \App\User::find($userId);
        $status = $user -> where('id',$userId) -> update([
            'family_id' => null
        ]);
        return $status?"删除成功":"删除失败";
    }
}
