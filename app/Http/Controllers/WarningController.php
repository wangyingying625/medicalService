<?php

namespace App\Http\Controllers;

use App\Detail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarningController extends Controller
{
    //
    public function getWarningInfo(Request $request)
    {
//        $user_id = $request->route('userId');
        $type = $request->route('IndicatorName');
//        if (!$user_id) {
//        dd($type);
            $user_id = Auth::id();
//        }
        $images = DB::select('SELECT id FROM images WHERE user_id = ? ORDER BY created_at DESC LIMIT 0,2', [$user_id]);
        $result = [];
        foreach ($images as $image) {
            $result[] = DB::select('SELECT
          indicators.name_ch,
          indicators.name_en,
          indicators.created_at,
          abs(indicators.value - indicators.upper_limit) AS u_abs,
          abs(indicators.value - indicators.lower_limit) AS l_abs
FROM indicators, images
WHERE indicators.image_id = ? AND indicators.image_id = images.id AND images.type = ? AND
      (indicators.value > indicators.upper_limit OR indicators.value < indicators.lower_limit)', [$image->id,$type]);
        }
        return $result;

        /*
         *
         * # SELECT * FROM images WHERE user_id = 2 ORDER BY created_at LIMIT 0,2
        SELECT
          *,
          abs(indicators.value - indicators.upper_limit) AS u,
          abs(indicators.value - indicators.lower_limit) AS l
        FROM indicators
        WHERE image_id = 11 AND
              (indicators.value > indicators.upper_limit OR indicators.value < indicators.lower_limit)
         */

    }

    public function getDetailByName(Request $request){
        $name = $request->route('IndicatorName');
        $detail = Detail::where('name_ch',$name)->first();
        return $detail;
    }
}
