<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function index()
    {
        $dataRol = Role::all(['name']);
        
        $dataUser = User::all(['nit','name']);

        return view('dash.coordinador.listRol')->with(compact('dataRol', 'dataUser'));
    }
    

    
}
