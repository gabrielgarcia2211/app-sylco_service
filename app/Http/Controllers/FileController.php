<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\DriveController;
use App\Models\File_User;

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

        $nombreContratista = auth()->user()->name;
        $nitContratista = auth()->user()->nit;

        echo ($files);
        return;

        $nombreArchivo = "data";
        $descripcionArchivo = "adat2";

        try {

            $file = $this->driveData->putFile($nombreContratista, $files->get());

            if ($file['response']) {


                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'descripcion' =>  $descripcionArchivo,
                    'file' =>   $file['message'][0][1],
                    'aceptacion' =>  '0'
                ]);


                File_User::create([
                    'user_nit' => $nitContratista,
                    'file_id' => $fileUp->id,
                    'date' => date('Y-m-d H:i:s')
                ]);

                return [
                    'response' => true,
                    'message' => 'file upload'
                ];
            } else {
                return $file['message'];
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
