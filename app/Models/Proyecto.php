<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{

    protected $table = 'proyectos';

    public $timestamps = false;

    protected $fillable =[
     'name',
     'descripcion',
     'ubicacion',
     'uuid',
     'status'
    ];

}
