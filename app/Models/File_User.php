<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File_User extends Model
{
    protected $table = 'file_users';
    public $timestamps = false;

    protected $fillable = ['user_nit','file_id','date'];
}
