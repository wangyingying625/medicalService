<?php

namespace App\Http\Controllers\Indicator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndicatorController extends Controller
{
    //

    public function showUpload(){
        var_dump(Auth::id());
        return view("indicator.upload");
    }
}
