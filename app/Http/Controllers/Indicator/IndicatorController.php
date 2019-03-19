<?php

namespace App\Http\Controllers\Indicator;

use App\Image;
use App\Indicator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\type;

class IndicatorController extends Controller
{
    //

    public function showUpload(){
        var_dump(Auth::id());
        return view("indicator.upload");
    }

    public function showOne(Request $request){
        $images = Image::where('user_id',Auth::id())->get();
        $indicators = [];
        foreach ($images as $image){
            $tmps = Indicator::where('image_id',$image['id'])->get(['name_ch']);
            foreach ($tmps as $tmp){
                $indicators[] = $tmp['name_ch'];
            }
        }
        $indicators = array_unique($indicators);
        return view('indicator.oneIndicator')->with(['indicators'=>$indicators]);
    }

    public function showIndicatorByUserId(Request $request){
        $indicators = array();
        $id = $request -> route('UserId');
        $types = DB::table('images')->select('type')->where('user_id',$id)->distinct()->get();
        foreach ($types as $type){
            $type = $type->type;
            $indicators[$type]=Image::where('user_id',$id)->where('type',$type)->orderBy('created_at')->get();
            foreach ($indicators[$type] as $foo){
                $foo['indicators'] = Indicator::where('image_id',$foo->id)->get();
            }
        }
        return $indicators;
    }

    public function showIndicatorByName(Request $request){
        $IndicatorNames = $request -> route('IndicatorName');
        $indicators = array();
        if ($IndicatorNames){
            $IndicatorNames = explode("&",$IndicatorNames);
            foreach ($IndicatorNames as $IndicatorName){
                $indicator = DB::select("SELECT indicators.id, 
                  indicators.name_ch, 
                  indicators.name_en, 
                  indicators.upper_limit, 
                  indicators.lower_limit, 
                  indicators.value, 
                  indicators.image_id, 
                  indicators.important, 
                  indicators.created_at 
                  FROM indicators,images 
                  WHERE 
                  images.user_id = ? 
                  AND indicators.image_id=images.id 
                  AND indicators.name_ch = ?",[Auth::id(),$IndicatorName]);
                    array_push($indicators,$indicator);
            }

        }

    return $indicators;
    }

    public function important(Request $request){
        $IndicatorName = $request -> route('IndicatorName');
        $Images = Image::where('user_id',Auth::id())->get();
        foreach ($Images as $image){
            Indicator::where('image_id',$image['id'])->where('name_ch',$IndicatorName)->update(['important'=>1]);
        }

        return view('location')->with(['title'=>'设置成功','message'=>$IndicatorName.'已显示在主页','url'=>'/home']);

    }

    public function unimportant(Request $request){
        $IndicatorName = $request -> route('IndicatorName');
        $Images = Image::where('user_id',Auth::id())->get();
        foreach ($Images as $image){
            Indicator::where('image_id',$image['id'])->where('name_ch',$IndicatorName)->update(['important'=>0]);
        }
        return view('location')->with(['title'=>'设置成功','message'=>$IndicatorName.'已取消在主页显示','url'=>'/home']);


    }

}
