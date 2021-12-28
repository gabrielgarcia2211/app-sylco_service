<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class ProyectoController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new DriveController();
    }


    public function index()
    {
        $dataProyecto = Proyecto::all();
        return view('dash.coordinador.listProyecto')->with(compact('dataProyecto'));
    }

    public function indexStore()
    {
        return view('dash.coordinador.addProyecto');
    }

    public function store(Request $request)
    {

        $this->validateStore($request);

        try {

            $carp = $this->driveData->createDirectory(strtoupper($request->nombre));

            if ($carp['response']) {

                Proyecto::create([
                    'name' =>  strtoupper($request->nombre),
                    'descripcion' =>  $request->descripcion,
                    'ubicacion' =>  $request->ubicacion,
                ]);

                return [
                    'response' => true,
                    'message' => 'Proyecto Creado!'
                ];
            } else {


                return [
                    'response' => false,
                    'message' => 'El Proyecto ya Existe!',
                ];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
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


        $proyect = Proyecto::find($id);

        if (empty($proyect)) {

            return [
                'response' => false,
                'message' => 'Proyecto no Existe'
            ];
        }

        $carp = $this->driveData->editDirectory($proyect->name, '/' , $name );

        if($carp['response']){
            try {

                $proyect->name =  $name;
                $proyect->descripcion =  $descripcion;
                $proyect->ubicacion =  $ubicacion;
    
                $proyect->update();
    
                return [
                    'response' => true,
                    'message' => 'Proyecto Actualizado'
                ];
            } catch (\Illuminate\Database\QueryException $e) {
    
                return [
                    'response' => false,
                    'message' => $e->getMessage()
                ];
            }
        }else{
            return [
                'response' => false,
                'message' => $carp['message']
            ];
        }


        
    }


    public function delete()
    {

        $nombre = $_POST['search'];


        $carp = $this->driveData->deleteFile(strtoupper($nombre),  "/", "", 3);

        try {
            if ($carp['response']) {

                $proyect = Proyecto::where('name', $nombre)->first();

                $proyect->delete();
                return [
                    'response' => true,
                    'message' =>  'Proyecto eliminado'
                ];
            }
            return [
                'response' => false,
                'message' =>  "Proyecto no registrado!"
            ];
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
