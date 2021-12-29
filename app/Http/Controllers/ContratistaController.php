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
       // $this->dataContratista = $this->cargaContratista();
    }

    public function showFile()
    {
        $nit = $_POST['nit'];
        $proyecto = $_POST['proyecto'];

        $data = User::select('proyectos.name AS proyecto', 'users.name AS nombre', 'users.nit')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
            ->where('users.nit',  '=', $nit)
            ->where('proyectos.name',  '=', $proyecto)->get();


        
        
        
        return;
    }


}
