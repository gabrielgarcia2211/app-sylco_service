<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
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
            $proyectos = Proyecto::all(['name', 'descripcion']);

            $dataProyecto = array();

            for ($i = 0; $i < count($proyectos); $i++) {
                array_push($dataProyecto, [$proyectos[$i]->name, $proyectos[$i]->descripcion, $this->randColor()]);
            }

            return view('dash.coordinador.index')->with(compact('dataContratista', 'dataProyecto'));
        } else if (auth()->user()->hasRole('Contratista')) {

                $data =null;

                return view('dash.contratista.index')->with(compact('data'));
                
        } else {

            dd("nada");
        }
    }


    function randColor()
    {
        return sprintf('#%06X', mt_Rand(0, 0xFFFFFF));
    }
}
