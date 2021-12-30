<?php

namespace App\Http\Controllers;

Use Alert;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Proyecto_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;





class ProyectoController extends Controller
{


    public function index()
    {
        $dataProyecto = Proyecto::all();
        return view('dash.coordinador.listProyecto')->with(compact('dataProyecto'));
    }

    public function indexStore()
    {
        $JString = "";
        return view('dash.coordinador.addProyecto')->with(compact('JString'));
    }

    public function store(Request $request)
    {

        $this->validateStore($request);

        $dataProyecto = Proyecto::where('name', strtoupper($request->nombre))->first();
        if (empty($dataProyecto)) {

            try {

                Proyecto::create([
                    'name' =>  strtoupper($request->nombre),
                    'descripcion' =>  $request->descripcion,
                    'ubicacion' =>  $request->ubicacion,
                ]);

                return [
                    'response' => true,
                    'message' => 'Proyecto Creado!'
                ];
            } catch (\Exception $e) {
                return [
                    'response' => false,
                    'message' => $e->getMessage()
                ];
            }
        } else {

            return [

                'response' => false,
                'message' => 'El Proyecto ya Existe!'

            ];
        }
    }

    protected function validateStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
        ]);
    }

    public function edit()
    {

        $name = $_POST['name'];
        $descripcion = $_POST['descripcion'];
        $ubicacion = $_POST['ubicacion'];
        $id = $_POST['id'];

        $dataProyecto = Proyecto::where('name', strtoupper($name))->first();
        $proyect = Proyecto::find($id);


        if (!empty($dataProyecto) && $name != $proyect->name) {
            return [
                'response' => false,
                'message' => 'El Proyecto ya Existe!'
            ];
        }

        if (empty($proyect)) {

            return [
                'response' => false,
                'message' => 'Proyecto no Encontrado'
            ];
        }



        try {

            $proyect->name =  $name;
            $proyect->descripcion =  $descripcion;
            $proyect->ubicacion =  $ubicacion;

            $proyect->update();

            return [
                'response' => true,
                'message' => 'Proyecto Actualizado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete()
    {
        $nombre = $_POST['search'];

        try {

            $proyect = Proyecto::where('name', $nombre)->first();

            $proyect->delete();

            return [
                'response' => true,
                'message' =>  'Proyecto eliminado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function indexFindProyecto()
    {
        return view('dash.coordinador.vincularProyecto');
    }

    public function FindProyecto()
    {
        //$JString = array();

        if (!empty($_POST['usuario'])) {

            $id = $_POST['usuario'];

            $user = User::where('nit', $id)->first();

            if (empty($user)) {
                
                Alert::error('Opps!', 'Usuario no Registrado');
                return back();

            }


            $userAdd = Proyecto::select('proyectos.name')
                ->join('proyecto_users', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
                ->join('users', 'users.nit', '=', 'proyecto_users.user_nit')
                ->where('users.nit', '=',  $id)->get();


            $userDelete = DB::select("SELECT  DISTINCTROW(proyectos.name) FROM proyectos 
            LEFT JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
            LEFT JOIN users ON users.nit = proyecto_users.user_nit
            WHERE  proyectos.name  NOT IN
            ( SELECT  proyectos.name FROM proyectos
                INNER JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
                INNER JOIN users ON users.nit = proyecto_users.user_nit 
                WHERE users.nit = $id)");

            $JString = array();


            $JString = [
                'agregar' => $userDelete,
                'eliminar' => $userAdd
            ];

            return view('dash.coordinador.vincularProyecto')->with(compact('JString'));
            
        } else {
           
            Alert::warning('Opps!', 'Pro favor, Ingrese Nit');
            return back();
        }
    }


    public function vincularProyecto()
    {

        $proyecto =  $_POST['proyecto'];
        $nit = $_POST['nit'];

        try {

            $user = User::where('nit', $nit)->first();
            $proyecto = Proyecto::where('name', $proyecto)->first();

            Proyecto_User::create([
                'user_nit' =>    $user->nit,
                'proyecto_id' =>  $proyecto->id
            ]);

            return [
                'response' => true,
                'message' =>  'Proyecto vinculado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function desvincularProyecto()
    {
        $proyecto =  $_POST['proyecto'];
        $nit = $_POST['nit'];

        try {

            $user = User::where('nit', $nit)->first();
            $proyecto = Proyecto::where('name', $proyecto)->first();

            Proyecto_User::where('user_nit', $user->nit)->where('proyecto_id', $proyecto->id)->delete();


            return [
                'response' => true,
                'message' =>  'Proyecto desnviculado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
