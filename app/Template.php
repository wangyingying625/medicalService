<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $fillable = ['name','name_en','name_ch','upper_limit','lower_limit','user_id','created_at'];

}
