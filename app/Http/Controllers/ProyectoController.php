<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class ProyectoController extends Controller
{


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
}
