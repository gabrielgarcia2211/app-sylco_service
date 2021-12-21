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
        return [
            'response' => true,
            'message' => Proyecto::all()
        ];
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

                Alert::success('Proceso Realizado', 'Proyecto Creado');
                return back();
            } else {
                Alert::error('Error', $carp['message']);
                return back();
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

    public function show(Request $request)
    {
        $this->validateShow($request);
        $proyect = Proyecto::find($request->id);

        if (empty($proyect)) {

            return [
                'response' => false,
                'message' => 'proyect not found'
            ];
        }

        return [
            'response' => true,
            'message' => $proyect
        ];
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

            return [
                'response' => false,
                'message' => 'proyect not found'
            ];
        }

        try {

            $proyect->name =  $request->name;
            $proyect->descripcion =  $request->descripcion;
            $proyect->ubicacion =  $request->ubicacion;

            $proyect->update();

            return [
                'response' => true,
                'message' => 'proyect update'
            ];
        } catch (\Illuminate\Database\QueryException $e) {

            return[
                'response' => false,
                'message' => $e->getMessage()
            ];
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
        $this->validateDestroy($request);
        $carp = $this->driveData->deleteFile(strtoupper($request->nombre),  "/", "", 3);

        try {
            if ($carp['response']) {

                $proyect = Proyecto::where('name', $request->nombre)->first();

                $proyect->delete();
                return [
                    'response' => true,
                    'message' =>  'Proyect delete'
                ];
            }
            return [
                'response' => false,
                'message' =>  "Proyect no register!"
            ];
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function validateDestroy(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);
    }
}
