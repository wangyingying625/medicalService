<?php

namespace App\Http\Controllers\Indicator;

use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    //
    /*
     * 模板上传，用户上传模板，如果选择模板上传，每次就把本次所以
     */
    function uploadTemplate(Request $request)
    {
        $templates = Template::where('user_id',Auth::id())->get();
        return view('indicator.temp')->with(['templates'=>$templates]);
    }

    function createTemplate(Request $request){
        $id = Auth::id();
        $name = $request->input('tempName');
        foreach($request->input('temp') as $template){
           $template['user_id']=$id;
           $template['name'] = $name;
           Template::create($template);
        }
        return view('location')->with(['title'=>'增加成功','message'=>"增加模板 $name 成功",'url'=>'/indicator/temp']);
    }

    function deleteTemplate(Request $request){
        $temp_id = $request -> route('TemplateId');
        $template = Template::Where('id',$temp_id);
    }

}
