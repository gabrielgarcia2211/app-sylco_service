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

    public function index()
    {
        $file = $this->driveData->listDirectory(strtoupper('natura'), strtoupper('arturo'));

        dd($file);
        //return csrf_token(); 
    }

    public function store(Request $request)
    {

        // $this->validateStore($request);

        $nombreArchivo = "data";

        try {

            $file = $this->driveData->putFile('DAVID', 'file.txt');
         
            if($file['response']) {

                
                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'descripcion' =>  'holaaaa',
                    'file' =>   $file['message'][0][1],
                    'aceptacion' =>  '0'
                ]);


                File_User::create([
                    'user_nit' => 13,
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

    protected function validateStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
    }
}
