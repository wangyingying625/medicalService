<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $fillable = ['temp_name_id','name_en','name_ch','upper_limit','lower_limit','created_at'];

}
