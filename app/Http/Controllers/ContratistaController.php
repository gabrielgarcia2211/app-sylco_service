<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratistaController extends Controller
{
    private $driveData;
    private $dataContratista;

    function __construct()
    {
        $this->driveData = new DriveController();
        $this->dataContratista = $this->cargaContratista();
    }

    private function cargaContratista()
    {
        $user = User::select('users.name', 'users.nit', 'users.email')->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')->where('roles.name', '=', 'Contratista')->get();

        return $user;
    }

    public function index()
    {
        $user =  $this->dataContratista;
        return view('dash.coordinador.index')->with(compact('user'));
    }

    public function file()
    {
        $resp = null;
        $user =  $this->dataContratista;
        $name = $user[0]->name;


        $data = DB::select(" SELECT proyectos.name proyecto, users.name  nombre FROM  users 
        INNER JOIN proyecto_users ON proyecto_users.user_nit = users.nit 
        INNER JOIN proyectos ON proyecto_users.proyecto_id = proyectos.id  WHERE  users.name  = '$name'");


        $dataProyecto = DB::select(" SELECT files.name nombre, files.descripcion, files.aceptacion FROM  files 
        INNER JOIN file_users ON file_users.file_id = files.id 
        INNER JOIN users ON file_users.user_nit = users.nit  WHERE  users.nit  = '355'");



        if (!empty($data)) {
            $resp = $this->driveData->listDirectory(strtoupper($data[0]->proyecto), strtoupper($data[0]->nombre));

            if (!$resp['response']) {
                dd($resp['message']);
            }
        }


       // dd($dataProyecto[4]->nombre);

        return view('dash.coordinador.archivos')->with(compact('user', 'resp', 'dataProyecto'));
    }
}
