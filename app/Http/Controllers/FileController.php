<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Proyecto;
use App\Models\File_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Log;

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
        $carpetaDestino = $request->input('carpeta');

        try {

            $ruta = $nombreContratista.'/'.$carpetaDestino;

            $file = $this->driveData->putFile($ruta, $files, $name);

            if ($file['response']) {


                $proyecto = Proyecto::where('name', $nombreProyecto)->first();

                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'name_drive' => $name,
                    'descripcion' =>  $descripcionArchivo,
                    'file' =>   $file['message'],
                    'proyecto_id' => $proyecto->id,
                    'aceptacion' =>  '0',
                    'ruta' => $ruta
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

            $data = $this->driveData->deleteFile($file->ruta, $file->file, 1);

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

        log::debug($archivo);
        $propietario = auth()->user()->id;
        log::debug($propietario);
        $temp = User::join('file_users','file_users.user_nit','=','users.nit')->join('files','file_users.file_id','=','files.id')->where('users.id',$propietario)->where('files.file',$archivo)->get()->toArray();
        log::debug($temp[0]['ruta']);
        $path = storage_path() . '/' . 'app' . '/' . $temp[0]['ruta'] . '/' . $archivo;
        if (file_exists($path)) {
            return Response::download($path);
        }else{
               
            Alert::warning('Opps!', 'Archivo no encontrado');
            return back();
        }
    }


}
