<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriveController extends Controller
{
    //CREAR UN DIRECTORIO PRINCIPAL
    public function createDirectory($nombre="hola"){
        

        try{

            if(!$this->findDirectory($nombre)){

                Storage::disk('google')->makeDirectory($nombre);

                return response()->json([
                    'response' => true,
                    'message' => 'Directorio Creado'
                ]);

            }else{

                return response()->json([
                    'response' => false,
                    'message' => 'El Directorio ya Existe'
                ]);

            }

           

        }catch (Exception $e) {

            return response()->json([
                'response' => false,
                'message' =>  $e->getMessage()
            ]);
        
        }

    }
    
    //ENCONTRAR UN DIRECTORIO
    public function findDirectory($folder){

        $dir = '/';
        $recursive = false; 
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));

        // Find the folder you are looking for...
        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $folder)
            ->first(); // There could be duplicate directory names!

        if (!$dir) {
            return false;
        }

        return true;
 

    }
   
}
