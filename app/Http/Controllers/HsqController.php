<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyecto;

class HsqController extends Controller
{

    public function index()
    {
        return view('dash.auxiliar.listFiles');
    }


    public function showProyecto($name)
    {

        $dataFiles = User::select('users.*', 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
            ->where('proyectos.name', $name)
            ->distinct()
            ->get();



        return view('dash.auxiliar.listContratista')->with(compact('dataFiles', 'name'));
    }


    public function showFile()
    {
        $nit = $_POST['nit'];
        $proyecto = $_POST['proyecto'];

        $proyecto = Proyecto::where('name', $proyecto)->first();

        $data = User::select('files.*', 'file_users.date AS fecha', 'users.name AS propietario')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
            ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
            ->join('files', 'files.id', '=', 'file_users.file_id')
            ->where('users.nit',  '=', $nit)
            ->where('files.proyecto_id', $proyecto->id)
            ->distinct()
            ->get();


        $JString = json_encode($data);
        echo $JString;
        return;
    }
}
