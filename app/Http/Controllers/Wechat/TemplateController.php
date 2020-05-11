<?php
namespace App\Http\Controllers\Wechat;

use AipOcr;
use App\Image;
use App\Indicator;
use App\Template;
use App\TemplateName;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class TemplateController extends Controller
{
    //
    function uploadTemplate(Request $request)
    {
        $templates = TemplateName::where('user_id', Auth::id())->get();
        return view('indicator.temp')->with(['templates' => $templates]);
    }

    function createTemplate(Request $request)
    {
        $openId = $request->input('openId');
        $user = User::where('openId', $openId)->first();
        $id = $user->id;
        $name = $request->input('tempName');
        $type = $request->input('type');
        $temp_name = TemplateName::create(['name' => $name, 'user_id' => $id, 'type' => $type]);
        foreach ($request->input('temp') as $template) {
            $template['temp_name_id'] = $temp_name['id'];
            Template::create($template);
        }
        return $temp_name;
    }

    function showTemplateByName(Request $request)
    {
        $temp = $request->input('name');
        $openId = $request->input('openId');
        $user = User::where('openId', $openId)->first();
        $id = $user->id;
        $temp_id = TemplateName::where('name', $temp)->where('user_id', $id)->first();
        $temps = Template::where('temp_name_id', $temp_id['id'])->get();
        return $temps;
    }

    function getTemplateByOpenId(Request $request)
    {
        $openId = $request->input('openId');
        $user = User::where('openId', $openId)->first();
        $id = $user->id;
        $templates = TemplateName::where('user_id', $id)->get();
        $res = [];
        foreach ($templates as $template) {
            array_push($res, $template['name']);
        }

        return $res;

    }

    public function uploadTmp(Request $request)
    {
        $file = $request->file('image');
        $name = $file->store('tmp', 'public');
        return ['id' => '1', 'name' => $name];
    }

    function OCR(Request $request)
    {
        $imageId = $request->input('image_id');
        $select = $request->input('select');
        $temp = $request->input('temp');
        $date = $request->input('date');
        $openId = $request->input('openId');
        $image = Image::find($imageId);
        $user = User::where('openId', $openId)->first();
        $id = $user->id;
        $temp_id = TemplateName::where('name', $temp)->where('user_id', $id)->first();
        $temp = $temp_id['id'];
        $file_path = storage_path('app/public/' . $select);
        $aipOcr = new AipOcr(env('BAIDU_APP_ID', ''), env('BAIDU_APP_KEY', ''), env('BAIDU_SECRET_KEY', ''));
        $result = $aipOcr->general(file_get_contents($file_path));
        $templates = Template::where('temp_name_id', $temp)->get();
        $i = 0;
        foreach ($templates as $template) {
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
        $indicators = Indicator::where('image_id', $imageId)->get();
        return ['status' => true, 'indicators' => $indicators];

    }


    function deleteTemplate(Request $request)
    {
        $temp = $request->input('name');
        $openId = $request->input('openId');
        $user = User::where('openId', $openId)->first();
        $id = $user->id;
        $temp_id = TemplateName::where('name', $temp)->where('user_id', $id)->first();
        $temp_id = $temp_id['id'];
        Template::Where('temp_name_id', $temp_id)->delete();
        TemplateName::find($temp_id)->delete();
        return ['status' => '删除成功'];

    }
}
