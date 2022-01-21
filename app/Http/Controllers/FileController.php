<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Proyecto;
use App\Models\File_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StorageController;

class FileController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new StorageController();
    }

    public function store(Request $request)
    {

        $files = $request->file('archivo');
        $name = time() . random_int(0, 100);

        $nombreContratista = auth()->user()->name;
        $nitContratista = auth()->user()->nit;

        $nombreArchivo = $request->input('nombre');
        $descripcionArchivo =  $request->input('descripcion');
        $nombreProyecto =  $request->input('proyecto');

        if( round($_FILES['archivo']['size']/1024) > 10240){
            return [
                'response' => false,
                'message' =>   'Limite de peso excedido, peso permitido 10MB'
            ];
        }

        try {

            $file = $this->driveData->putFile($nombreContratista, $files, $name);

            if ($file['response']) {


                $proyecto = Proyecto::where('name', $nombreProyecto)->first();

                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'name_drive' => $name,
                    'descripcion' =>  $descripcionArchivo,
                    'file' =>   $file['message'],
                    'proyecto_id' => $proyecto->id,
                    'aceptacion' =>  '0'
                ]);


                File_User::create([
                    'user_nit' => $nitContratista,
                    'file_id' => $fileUp->id,
                    'date' => date('Y-m-d H:i:s')
                ]);

                return [
                    'response' => true,
                    'message' => 'Archivo subido!'
                ];
            } else {

                return [
                    'response' => false,
                    'message' =>  $file['message']
                ];
            }
        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function destroy()
    {
        $id = $_POST['id'];
        $file = File::Find($id);

        try {

            $data = $this->driveData->deleteFile(auth()->user()->name,  $file->file, 1);

            if ($data['response']) {
                $file->delete();
                return [
                    'response' => true,
                    'message' =>  'Archivo eliminado'
                ];
            }

            return [
                'response' => false,
                'message' =>  'Archivo no encontrado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function dowloandFile($archivo,$propietario){

      
        $path = storage_path() . '/' . 'app' . '/' . $propietario .  '/' . $archivo;
        if (file_exists($path)) {
            return Response::download($path);
        }else{
               
            Alert::warning('Opps!', 'Archivo no encontrado');
            return back();
        }
    }


}
