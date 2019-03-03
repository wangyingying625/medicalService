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
//        return view('record')->with('data',$indicators);
    }


}
