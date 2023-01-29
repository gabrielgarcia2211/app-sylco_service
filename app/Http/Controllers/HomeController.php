<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (auth()->user()->hasRole('Coordinador')) {

            $dataContratista = DB::select("SELECT count('role_id') as contratista FROM model_has_roles WHERE role_id = 3 ");
            $dataFiles = User::select('users.*', 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId')->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')->join('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')->get();
            $proyectos = Proyecto::select('name', 'descripcion')->where('status', 0)->get();

            $dataProyecto = array();

            for ($i = 0; $i < count($proyectos); $i++) {
                array_push($dataProyecto, [$proyectos[$i]->name, $proyectos[$i]->descripcion, $this->randColor()]);
            }

            return view('dash.coordinador.index')->with(compact('dataContratista', 'dataProyecto', 'dataFiles'));
        } else if (auth()->user()->hasRole('Contratista')) {


            $data = DB::select("SELECT  DISTINCT proyectos.name AS proyecto, COUNT(files.name) AS cantidad
            FROM proyectos 
            INNER JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
            INNER JOIN users ON users.nit = proyecto_users.user_nit
            INNER JOIN file_users ON file_users.user_nit = users.nit
            INNER JOIN files ON files.id = file_users.file_id
            WHERE files.proyecto_id = proyectos.id AND users.nit =" . auth()->user()->nit . "
            GROUP BY (proyecto)");

            $dataProyecto = array();


            for ($i = 0; $i < count($data); $i++) {
                array_push($dataProyecto, [$data[$i]->proyecto, $data[$i]->cantidad,  $this->randColor()]);
            }


            return view('dash.contratista.index')->with(compact('dataProyecto'));
        } else if (auth()->user()->hasRole('Aux')) {


            $data = DB::select("SELECT  DISTINCT proyectos.name AS proyecto, COUNT(files.name) AS cantidad
            FROM files, proyectos 
            INNER JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
            INNER JOIN users ON users.nit = proyecto_users.user_nit
            WHERE files.proyecto_id = proyectos.id AND users.nit =" . auth()->user()->nit . "
            GROUP BY (proyecto)");

            $dataProyecto = array();


            for ($i = 0; $i < count($data); $i++) {
                array_push($dataProyecto, [$data[$i]->proyecto, $data[$i]->cantidad,  $this->randColor()]);
            }
            return view('dash.auxiliar.index')->with(compact('dataProyecto'));
        } else {
            dd("no tiene permisos");
        }
    }


    function randColor()
    {
        return sprintf('#%06X', mt_Rand(0, 0xFFFFFF));
    }
}
