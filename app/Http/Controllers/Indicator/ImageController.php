<?php

namespace App\Http\Controllers\Indicator;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
    public function upload(Request $request){
//        $file = $request->file('image');
//        $name = $file->store('upload','public');
//        $image = new Image();
//        $image->name = $name;
//        $image->user_id = 1;
//        $image->save();
//        return $image;
        var_dump(Auth::id());


    }

}
