<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 'SMS_Log';
    protected $fillable = ['SMS_code','SMS_mobile','updated_at'];

}
