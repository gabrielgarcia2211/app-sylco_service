<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new DriveController();
    }


    public function index()
    {
        return response()->json([
            'response' => true,
            'message' => Proyecto::all()
        ]);
        //return csrf_token(); 
    }

    public function store(Request $request)
    {

        //$this->validateStore($request);

        try {

            $carp = $this->driveData->createDirectory(strtoupper($request->nombre));
            
            if ($carp['response']) {

                Proyecto::create([
                    'name' =>  $request->nombre,
                    'descripcion' =>  $request->descripcion,
                    'ubicacion' =>  $request->ubicacion,
                ]);

                return [
                    'response' => true,
                    'message' => 'Proyecto Creado'
                ];
            } else {
                dd($carp['message']);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function validateStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
        ]);
    }

    public function show(Request $request)
    {
        $this->validateShow($request);
        $proyect = Proyecto::find($request->id);

        if (empty($proyect)) {

            return response()->json([
                'response' => false,
                'message' => 'proyect not found'
            ]);
        }

        return response()->json([
            'response' => true,
            'message' => $proyect
        ]);
    }

    protected function validateShow(Request $request)
    {

        $this->validate($request, [
            'id' => 'required',
        ]);
    }

    public function edit(Request $request)
    {
        $this->validateEdit($request);
        $proyect = Proyecto::find($request->id);

        if (empty($proyect)) {

            return response()->json([
                'response' => false,
                'message' => 'proyect not found'
            ]);
        }

        try {

            $proyect->name =  $request->name;
            $proyect->descripcion =  $request->descripcion;
            $proyect->ubicacion =  $request->ubicacion;

            $proyect->update();

            return response()->json([
                'response' => true,
                'message' => 'proyect update'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function validateEdit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
        ]);
    }

    public function destroy(Request $request)
    {
        $proyect = Proyecto::find($request->id);

        if (empty($role)) {
            return response()->json([
                'response' => false,
                'message' =>  "Proyect no register!"
            ]);
        }

        try {

            $proyect->delete();
            return response()->json([
                'response' => true,
                'message' =>  'Rol delete'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
