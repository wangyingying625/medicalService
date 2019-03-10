<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::id();
        $indicator = DB::select("SELECT distinct indicators.name_ch
                FROM images, indicators
                WHERE images.id = indicators.image_id AND images.user_id = ? AND indicators.important = 1"
            ,[$id]);
        $indicator = \GuzzleHttp\json_encode($indicator);
        return view('welcome')->with(['data'=>$indicator]);
    }
}
