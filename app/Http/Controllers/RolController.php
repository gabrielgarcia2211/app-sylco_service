<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function index()
    {
        return view('dash.coordinador.listRol');
    }

    public function findRolUser()
    {
        $id = 1;


        $userRolAdd = User::find($id);
        $data = $userRolAdd->getRoleNames();


        $userRolDelete = DB::select("SELECT  DISTINCTROW(roles.name) FROM roles 
        LEFT JOIN model_has_roles ON model_has_roles.role_id = roles.id
        LEFT JOIN users ON users.id = model_has_roles.model_id 
        WHERE roles.name NOT IN
            (SELECT  roles.name
            FROM roles 
            LEFT JOIN model_has_roles ON model_has_roles.role_id = roles.id
            LEFT JOIN users ON users.id = model_has_roles.model_id 
            WHERE users.id = 1)
        ");

        $JString = json_encode($data);
        $JString2 = json_encode($userRolDelete);

        $outp =  [
            'agregar' => $JString,
            'eliminar' => $JString2,
        ];

        dd($outp);
    }
}
