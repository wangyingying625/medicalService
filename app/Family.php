<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    //
    protected $table = 'familys';

    protected $primaryKey = 'id';

    protected $fillable = ['name'];
}
