<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\File;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratistaController extends Controller
{

    public function index()
    {
        return view('dash.coordinador.listFiles');
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


    public function showProyecto($name)
    {


        $proyecto = Proyecto::where('name', $name)->first();

        $dataFiles = File::select('files.*')
            ->join('file_users', 'file_users.file_id', '=', 'files.id')
            ->join('users', 'users.nit', '=', 'file_users.user_nit')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
            ->where('users.nit', auth()->user()->nit)
            ->where('files.proyecto_id', $proyecto->id)
            ->distinct()
            ->get();



            return view('dash.contratista.listProyecto')->with(compact('name','dataFiles'));
    }
}
