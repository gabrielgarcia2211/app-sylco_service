<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratistaController extends Controller
{

    public function index(){
        return view('dash.coordinador.listFiles');
    }

    public function showFile()
    {
        $nit = $_POST['nit'];
        $proyecto = $_POST['proyecto'];

        $data = User::select('files.*', 'file_users.date AS fecha', 'users.name AS propietario')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
            ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
            ->join('files', 'files.id', '=', 'file_users.file_id')
            ->where('users.nit',  '=', $nit)
            ->where('proyectos.name',  '=', $proyecto)->get();

        
        $JString = json_encode($data);
        echo $JString;
        return;
    }


}
