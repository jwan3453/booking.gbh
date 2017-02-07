<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table     = 'user_profile';

    protected $fillable  = ['user_name','email','birth_year','birth_month','birth_day','signature'];

    public $timestamps   = false;
}
?>