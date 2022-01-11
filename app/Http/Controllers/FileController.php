<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\DriveController;
use App\Models\File_User;
use App\Models\Proyecto;
use App\Models\User;
use App\Mail\TestMail;
use Mail;


class FileController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new DriveController();
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

        try {

            $file = $this->driveData->putFile($nombreContratista, $files->get(), $name);

            if ($file['response']) {


                $proyecto = Proyecto::where('name', $nombreProyecto)->first();


                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'name_drive' => $name,
                    'descripcion' =>  $descripcionArchivo,
                    'file' =>   $file['message'][0][1],
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

            $data = $this->driveData->deleteFile(auth()->user()->name,  $file->name_drive, 1);

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

}
