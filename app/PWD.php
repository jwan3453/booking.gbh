<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PWD extends Model
{
    protected $table = 'PWD_Log';
    protected $fillable = ['username','email','addressKey','updated_at'];
}
