<?php

namespace App\Http\Controllers\Indicator;

use AipOcr;
use App\Image;
use App\Indicator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Array_;

const APP_ID = 'l3QjgNFp9SfrldOlsGmX0hkx';
const API_KEY = 'l3QjgNFp9SfrldOlsGmX0hkx ';
const SECRET_KEY = '1geqDEj3jeWBalQBao6KiOqARARZ3q48';


class ImageController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        $file = $request->file('image');
        $name = $file->store('upload', 'public');
        $image = new Image();
        $image->name = $name;
        $image->user_id = Auth::id();
        $image->save();
        return $image;

    }

    public function uploadTmp(Request $request){
        $file = $request->file('image');
        $name = $file->store('tmp', 'public');
        return ['id'=>'1','name'=>$name];
    }

    public function showUploadForm()
    {
//        $userImages = Image::where('user_id', Auth::id())->orderBy('created_at','DESC')->get();
        return view('indicator.pictures');
    }

    public function record(Request $request)
    {
        $UserId = $request->route('UserId');
        $user = User::find($UserId);
        return view('indicator.record')->with(['user' => $user]);
    }

    public function changeImageDate(Request $request)
    {

        $ImageId = $request->route('ImageId');
        $indicators = Indicator::where('image_id', $ImageId)->get();
//        var_dump($indicators);
        return view('indicator.table')->with('indicators', $indicators);
    }

    public function saveImageDate(Request $request)
    {
        //默认保存成功
        $status = 1;
        $indicators = $request->input();
        foreach ($indicators as $id => $indicator) {
            if (is_array($indicator)) {
                //var_dump($id);
                //var_dump($indicator);
                $indicator = array_add($indicator, 'created_at', session('date'));
                //Indicator::find($id)->update($indicator);
                if (Indicator::find($id)->update($indicator) == false)
                    $status = 0;
            }
        }
        //删除session中的date字段
        session()->forget('date');
        if ($status == 1) {
            return view('location')->with(['title' => '提示', 'message' => '保存成功', 'url' => '/indicator/record/' . Auth::user()->id]);
        } else {
            return view('location')->with(['title' => '提示', 'message' => '保存失败', 'url' => '/indicator/record/' . Auth::user()->id]);
        }
    }

    public function OCR(Request $request)
    {
        session([
            'date' => $request->input('date')
        ]);
        $is_memory = $request->input('is_memory', false);
// 初始化
        $fault_tolerance = 50;
        $imageId = $request->input('image_id');
        $type = $request->input('type');
        $image = Image::find($imageId);
        $image->type = $type;
        $image->created_at = $request->input('date');
        $image->save();
//        var_dump($image);
//        var_dump(storage_path('app/public/'.$image->name));
        $file_path = storage_path('app/public/' . $image->name);
        $aipOcr = new AipOcr(APP_ID, API_KEY, SECRET_KEY);
        $result = $aipOcr->general(file_get_contents($file_path));
//        var_dump($result);
        $NAMEFLAGS = ['项目', '名称'];
//        $columns = ['行','项目名称','校验结果','单位','参考值','实验方法'];
        $headTop = 0;
        $columns = [];
        foreach ($result as $item) {
            if (is_array($item)) {
                $result = $item;
            }
        }
        $tmp = 0;
        foreach ($result as $item) {
            foreach ($NAMEFLAGS as $column) {
                if (strpos($item['words'], $column)) {
                    $headTop = $item['location']['top'];
                    $tmp = 1;
                    break;
                }
            }
            if ($tmp) {
                break;
            }
        }

        $table = [];
        $flag = 0;
        if ($headTop != 0) {
            $row = [];
            foreach ($result as $item) {
                $deviation = $item['location']['top'] - $headTop;
                if (abs($deviation) < $fault_tolerance) {
                    $flag = 1;
                    array_push($row, $item['words']);
                } elseif ($flag) {
                    if (count($row) != 0 && count($row) == 1) {

                        break;
                    }
                    array_push($table, $row);
                    $row = [];
                    array_push($row, $item['words']);
                    $headTop = $item['location']['top'];
                }
            }
        }
        $tableHead = $table[0];
        unset($table[0]);
        $indicators = [];
        $i = 0;
        $last_indicators_list = [];
        if ($is_memory) {
            $last_images = Image::where('user_id', Auth::id())->where('type', $type)->first();
            $last_indicators = Indicator::where('image_id',$last_images['id'])->get();
            foreach ($last_indicators as $last_indicator) {
                $last_indicator = $last_indicator->toArray();
                $last_indicator['image_id'] = $imageId;
                $last_indicators_list[] = $last_indicator;
            }
        }

        foreach ($table as $item) {
            $indicators_value = $this->arrayToIndicators($item, $imageId);
            array_push($indicators, $indicators_value);
            if (!$is_memory) {
                Indicator::create($indicators_value);
            } else {
                $last_indicators_list[$i]['value']=$indicators_value['value'];
                Indicator::create($last_indicators_list[$i]);
                $i++;
            }
        }
        return Redirect::to("/indicator/changeData/".$imageId);
    }


//    function checkCh($name_ch){
//        var_dump($name_ch);
//        $name_ch = str_replace("★","",$name_ch);
//        var_dump($name_ch);
//        return $name_ch;
//    }

    function arrayToIndicators($row, $imagesId)
    {
        /*
         * 输入: $table 中的一行
         * 处理规则： 纯中文的为 ‘name_cn’,前两列出现的英文为 'name_en',
         * （根据校医院hack了一波：中文（英文#%）的类型直接取出来中文为'name_ch',括号内为'name_en',
         * 为数字或 ‘阴\阳’ 的判断为value
         * 三行后出现 字母的为单位
         * 数字---数字的形式为下限和上限
         * 输出：
         * {
         * ['name_ch']:xx,
         *
         * }
         */
        $indicators = [];
        $indicators['image_id'] = $imagesId;
        foreach ($row as $key => $item) {
            if (preg_match("/[\x7f-\xff]/", $item)) {
//                存在中文，确认包含中文指标名称
                if (preg_match("/\(([A-Za-z0-9#%]+)\){0,1}/", $item, $result)) {
//                    存在括号，括号内为英文指标
                    $indicators['name_en'] = $result[1];
                    preg_match("/([\x7f-\xff]+)\(.+\){0,1}/", $item, $result);
//                    $result = $this->checkCh($result[1]);
                    $indicators['name_ch'] = $result[1];
//                    var_dump($result[1]);

                }else{
//                    var_dump($item);
//                    echo $item;
                    $indicators['name_ch'] = $item;
                }
            } elseif (preg_match("/^(-?\d+)(\.\d+)?$/", $item)) {
                $indicators['value'] = $item;
            } elseif ($key > 1 && (strpos($item, '/') || preg_match("/^[A-Za-z]+$/", $item) || $item == '%')) {
//                这里为单位

                $indicators['unit'] = $item;
            } elseif (preg_match("/^([0-9]+\.{0,1}[0-9]{0,2})[^0-9]+([0-9]+\.{0,1}[0-9]{0,2})$/", $item, $result)) {
                $indicators['upper_limit'] = $result[1];
                $indicators['lower_limit'] = $result[2];

            }

        }

        return $indicators;


    }


    function deleteImage(Request $request){
        $ImageId = $request->route('ImageId');
        $deleted = Image::destroy($ImageId);
        Indicator::where('image_id',$ImageId)->delete();
        if ($deleted){
            return view('location')->with(['title' => '提示', 'message' => '删除成功', 'url' => '/indicator/history']);

        }

    }

}
