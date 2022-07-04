<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = ['name', 'name_drive','descripcion','file','aceptacion','created_at', 'proyecto_id', 'ruta'];
}
