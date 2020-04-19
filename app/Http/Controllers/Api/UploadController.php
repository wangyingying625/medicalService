<?php

namespace App\Http\Controllers\Api;

use AipOcr;
use App\Image;
use App\Indicator;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UploadController extends Controller
{
    //
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $userId = $request->input('userId');
        $user = User::where('id', $userId)->first();
        $name = $file->store('upload', 'public');
        $image = new Image();
        $image->name = $name;
        $image->user_id = $user->id;
        $image->save();
        return $image;
    }

    public function OCR(Request $request)
    {
        DB::beginTransaction();
        $imageId = $request->input('image_id');
        $image = Image::find($imageId);
        //dd($image);
        try {
            $user_id = $request->input('userId');
            $is_memory = $request->input('is_memory', false);
// 初始化
            $fault_tolerance = 50;
            $type = $request->input('type');
            $image->type = $type;

        $image->save();
//dd($image);
//
//        var_dump(storage_path('app/public/'.$image->name));
            $file_path = storage_path('app/public/' . $image->name);
            $aipOcr = new AipOcr(env('BAIDU_APP_ID',''), env('BAIDU_APP_KEY',''), env('BAIDU_SECRET_KEY',''));
            $result = $aipOcr->general(file_get_contents($file_path));
            //dd($result);
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
                $last_images = Image::where('user_id', $user_id)->where('type', $type)->first();
                $last_indicators = Indicator::where('image_id', $last_images['id'])->get();
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
                    $last_indicators_list[$i]['value'] = $indicators_value['value'];
                    Indicator::create($last_indicators_list[$i]);
                    $i++;
                }
            }

            $indicators = Indicator::where('image_id', $imageId)->get();
            foreach ($indicators as $id => $indicator) {
                if (is_array($indicator)) {
                    $indicator->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $image->delete();

            return ['status'=>false];
        }
//        var_dump($indicators);
        return ['status'=>true,'indicators'=>$indicators];

//        return Redirect::to("/indicator/changeData/".$imageId."?date=".$date);
    }
    public function record(Request $request)
    {
        $UserId = $request->route('UserId');
        $user = User::find($UserId);
        return view('indicator.record')->with(['user' => $user]);
    }


    public function saveImageDate(Request $request)
    {
        //默认保存成功
        $status = 1;
        $indicators = $request->input();
        $date = $request->input('date');
        foreach ($indicators as $id => $indicator) {
            if (is_array($indicator)) {
                $indicator = array_add($indicator, 'created_at', $date);
                if (Indicator::find($id)->update($indicator) == false)
                    $status = 0;
            }
        }
        if ($status == 1) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }
    }



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

                } else {
//                    var_dump($item);
//                    echo $item;
                    $indicators['name_ch'] = $item;
                }
            } elseif (preg_match("/^(-?\d+)(\.\d+)?$/", $item)) {
                $indicators['value'] = $item;
            } elseif ($key > 1 && (strpos($item, '/') || preg_match("/^[A-Za-z]+$/", $item) || $item == '%')) {
//                这里为单位
                $indicators['unit'] = $item;
                if (preg_match("/^(.+)\/m{0,1}1{1,2}([0-9]+\.{0,1}[0-9]{0,2})-{1,2}([0-9]+\.{0,1}[0-9]{0,2})$/", $item, $result)) {

                    $indicators['unit'] = $result[1] . '/l';
                    $indicators['upper_limit'] = $result[2];
                    $indicators['lower_limit'] = $result[3];
                }
            } elseif (preg_match("/^([0-9]+\.{0,1}[0-9]{0,2})[^0-9]+([0-9]+\.{0,1}[0-9]{0,2})$/", $item, $result)) {
                $indicators['upper_limit'] = $result[1];
                $indicators['lower_limit'] = $result[2];

            }

        }

        return $indicators;


    }


    public function showIndicatorByOpenId(Request $request)
    {
        $indicators = array();
        $openId = $request->input('openId');
        $id = User::where('openId', $openId)->first()->id;
        $types = DB::table('images')->select('type')->where('user_id', $id)->distinct()->get();
        foreach ($types as $type) {
            $type = $type->type;
            $indicators[$type] = Image::where('user_id', $id)->where('type', $type)->orderBy('created_at')->get();
            foreach ($indicators[$type] as $foo) {
                $foo['indicators'] = Indicator::where('image_id', $foo->id)->get();
            }
        }
        return $indicators;
    }

    public function showIndicator(Request $request)
    {
        $indicators = array();
        $user = Auth::guard('api')->user();
        $id = $user->id;
        $types = DB::table('images')->select('type')->where('user_id', $id)->distinct()->get();
        foreach ($types as $type) {
            $type = $type->type;
            $indicators[$type] = Image::where('user_id', $id)->where('type', $type)->orderBy('created_at')->get();
            foreach ($indicators[$type] as $foo) {
                $foo['indicators'] = Indicator::where('image_id', $foo->id)->get();
            }
        }
        return $indicators;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function checkTime(Request $request)
    {
        $openId = $request->input('openId');
        $id = User::where('openId', $openId)->first()->id;
        $result = [];
        $result['status'] = true;

        $userImage = Image::where('user_id', $id)->orderBy('created_at', 'DESC')->first();

        if ($userImage) {
            $last_time = new DateTime($userImage->created_at);
            $now = new DateTime();
            $days = $last_time->diff($now)->days;
            $result['days'] = $days;
        } else {
            $result['status'] = false;
        }

        return $result;
    }
    function getTemplate(Request $request)
    {
        $templates = TemplateName::where('user_id',Auth::id())->get();
        return  $templates;
    }
    public function uploadTmp(Request $request)
    {
        $file = $request->file('image');
        $name = $file->store('tmp', 'public');
        return ['id' => '1', 'name' => $name];
    }
}
