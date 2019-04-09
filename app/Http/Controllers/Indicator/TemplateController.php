<?php

namespace App\Http\Controllers\Indicator;

use AipOcr;
use App\Image;
use App\Indicator;
use App\Template;
use App\TemplateName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

const APP_ID = 'l3QjgNFp9SfrldOlsGmX0hkx';
const API_KEY = 'l3QjgNFp9SfrldOlsGmX0hkx ';
const SECRET_KEY = '1geqDEj3jeWBalQBao6KiOqARARZ3q48';


class TemplateController extends Controller
{
    //
    /*
     * 模板上传，用户上传模板，如果选择模板上传，每次就把本次所以
     */
    function uploadTemplate(Request $request)
    {
        $templates = TemplateName::where('user_id',Auth::id())->get();
        return view('indicator.temp')->with(['templates'=>$templates]);
    }

    function createTemplate(Request $request){
        $id = Auth::id();
        $name = $request->input('tempName');
        $type = $request->input('type');
        $temp_name = TemplateName::create(['name'=>$name,'user_id'=>$id,'type'=>$type]);
        foreach($request->input('temp') as $template){
           $template['temp_name_id']=$temp_name['id'];
           Template::create($template);
        }
        return view('location')->with(['title'=>'增加成功','message'=>"增加模板 $name 成功",'url'=>'/indicator/temp']);
    }

    function OCR(Request $request){
        session([
            'date' => $request->input('date')
        ]);
        $imageId = $request->input('image_id');
        $image = Image::find($imageId);
        $select = $request->input('select');
        $temp = $request->input('temp');
        $date = $request->input('date');

        $file_path = storage_path('app/public/' . $select);
        $aipOcr = new AipOcr(APP_ID, API_KEY, SECRET_KEY);
        $result = $aipOcr->general(file_get_contents($file_path));
        $templates = Template::where('temp_name_id',$temp)->get();
        $i = 0;
        foreach ($templates as $template){
            $indicator = $template->toArray();;
            $indicator['image_id'] = $imageId;
            $indicator['created_at'] = $date;
            $indicator['value'] = $result['words_result'][$i]['words'];
            Indicator::create($indicator);
            $i++;
        }
        $template_name = TemplateName::find($temp);
        $image->type = $template_name['type'];
        $image->created_at = $date;
        $image->save();
        return Redirect::to("/indicator/changeData/".$imageId);

    }

    function deleteTemplate(Request $request){
        $temp_id = $request -> route('TemplateId');
        Template::Where('temp_name_id',$temp_id)->delete();
        TemplateName::find($temp_id)->delete();
        return view('location')->with(['title'=>'提示','message'=>"删除成功",'url'=>'/indicator/temp']);

    }

    function showTemplateByName(Request $request){
        $temp_id = $request -> route('TemplateNameId');
        $temps = Template::where('temp_name_id',$temp_id)->get();
        return $temps;
    }

}
