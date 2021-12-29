<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function index()
    {
        return view('dash.coordinador.listRol');
    }

    public function findRolUser()
    {
        $nit = 1;
        $userRolDelete = array();


        $userRolAdd = User::where('nit', $nit)->first();
        $catRol = Role::count();
        $data = $userRolAdd->getRoleNames();

        for ($j = 0; $j < $catRol; $j++) {
            echo $data[$j];
            array_push($userRolDelete, Role::select('name')->whereNotIn('name', [$data[$j]])->first());
        }

        $JString = json_encode($data);
        $JString2 = json_encode($userRolDelete);

        $outp =  [
            'agregar' => $JString,
            'eliminar' => $JString2,
        ];

        dd($outp);
    }
}
