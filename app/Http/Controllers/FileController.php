<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{

    function __construct()
    {
        
    }

    public function index()
    {
        return response()->json([
            'response' => true, 
            'message' => File::all()
        ]);
        //return csrf_token(); 
    }
    
    public function store(Request $request)
    {
        
        $this->validateStore($request);

        try {

            $role = File::create(['name' =>  $request['name']]);
            return response()->json([
                'response' => true,
                'message' => 'file upload'
            ]);

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
