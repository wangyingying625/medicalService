<?php

namespace App\Http\Controllers\Indicator;

use App\Image;
use App\Indicator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
    public function upload(Request $request){
        $file = $request->file('image');
        $name = $file->store('upload','public');
        $image = new Image();
        $image->name = $name;
        $image->user_id = Auth::id();
        $image->save();
        return $image;

    }

    public function changeImageDate(Request $request){

        $ImageId = $request -> route('ImageId');

        $indicators = Indicator::where('image_id',$ImageId)->get();
//        var_dump($indicators);
        return view('indicator.table')->with('indicators',$indicators);
    }

    public function saveImageDate(Request $request){

        $indicators = $request -> input();
        var_dump($indicators);
        foreach ($indicators as $id => $indicator) {
            if (is_array($indicator)) {
                var_dump($id);
                var_dump($indicator);
                Indicator::find($id)->update($indicator);
            }
        }

    }

}
