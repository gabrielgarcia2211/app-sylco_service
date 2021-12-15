<?php

namespace App\Models;
¿
use Illuminate\Database\Eloquent\Model;

class Proyecto_User extends Model
{
    protected $table = 'proyecto_users';

    protected $fillable = ['user_nit','proyecto_id'];
}
