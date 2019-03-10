<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    //
    protected $fillable = ['name_en','name_ch','upper_limit','lower_limit','value','image_id','unit'];
}
