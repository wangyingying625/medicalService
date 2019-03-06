<?php

namespace App\Http\Controllers\Indicator;

use App\Image;
use App\Indicator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndicatorController extends Controller
{
    //

    public function showUpload(){
        var_dump(Auth::id());
        return view("indicator.upload");
    }

    public function showIndicator(){
        $indicators = array();
        $id = Auth::id();
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
        $IndicatorName = $request -> route('IndicatorName');
        $indicators = DB::select("SELECT indicators.id, 
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
    return $indicators;
    }


}
