<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File_User extends Model
{
    protected $table = 'file_users';

    protected $fillable = ['user_nit','file_id','date'];
}
