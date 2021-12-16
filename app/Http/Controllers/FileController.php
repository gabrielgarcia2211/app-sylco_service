<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\DriveController;

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

        try {

            $file = $this->driveData->putFile(strtoupper('natura'), strtoupper('arturo'), 'file.txt');

           

            if($file['response']) {

                
                $archivo = File::create([
                    /*'name' =>  $request->name,
                    'descripcion' =>  $request->descripcion,
                    'file' =>  $request->file,
                    'aceptacion' =>  $request->aceptacion*/

                    'name' =>  $file['message'],
                    'descripcion' =>  'holaaaa',
                    'file' =>  '',
                    'aceptacion' =>  '0'

                ]);
                
                return response()->json([
                    'response' => true,
                    'message' => 'file upload'
                ]);

                
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
