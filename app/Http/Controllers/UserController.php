<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'response' => true, 
            'message' => User::all()
        ]);
        //return csrf_token(); 
    }
    
    public function store(Request $request)
    {
        
        $this->validateStore($request);

        $role = Role::where('name', $request->role )->first();

        if(empty($role)){
            return response()->json([
                'response' => false,
                'message' => 'Role not found'
            ]);
        }

        try {

            $user = User::create([
                    'nit'=>  $request->nit,
                    'name' =>  strtoupper($request->name),
                    'last_name'=>  strtoupper($request->last_name),
                    'email'=>  $request->email,
                    'password' => Hash::make($request->password),
                    'role' =>  $request->role
                ]);
            
            $user->assignRole($role);

            return response()->json([
                'response' => true,
                'message' => 'create user'
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
            'nit'=> 'required|integer|unique:users,nit',
            'last_name'=> 'required',
            'email'=> 'required|unique:users,email',
            'password'=> 'required',
            'name' => 'required',
            'role' => 'required'
        ]);

    }

    public function show(Request $request)
    {
        $this->validateShow($request);
        $user = User::where('nit', '=',  $request->nit)->first();

        if(empty($user)){

            return response()->json([
                'response' => false,
                'message' => 'user not found'
            ]);

        }

        return response()->json([
            'response' => true,
            'message' => $user
        ]);

    }

    protected function validateShow(Request $request)
    {

        $request->validate([
            'nit' => 'required|integer',
        ]);

    }

    public function edit(Request $request)
    {
        //$this->validateEdit($request);
        $user = User::where('nit', '=',  $request->nit)->first();


        if(empty($user)){

            return response()->json([
                'response' => false,
                'message' => 'user not found'
            ]);

        }

        try {
            $user->nit = $request->nit;
            $user->last_name = strtoupper($request->last_name);
            $user->email = $request->email;
            $user->name = strtoupper($request->name);

            $user->update();

            return response()->json([
                'response' => true,
                'message' => 'user update'
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
        $request->validate([
            'nit'=> 'required|integer|unique:users,nit',
            'last_name'=> 'required',
            'email'=> 'required|unique:users,email',
            'name' => 'required',
        ]);
    }

    public function destroy(Request $request)
    {
        $user = User::where('nit', '=',  $request->nit)->first();

        if(empty($user)){
            return response()->json([
                'response' => false,
                'message' =>  "user no register!"
            ]);
        }

        try {

            $user->delete();
            return response()->json([
                'response' => true,
                'message' =>  'user delete'
            ]);
                    
            } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }

    }


    //-------------------------------------

    public function aggRole(Request $request){

        //$this->validateaggRole($request);

        $user = User::where('nit', $request->nit)->first();
        $role = Role::where('name', $request->name )->first();



        if(empty($role)){
            return response()->json([
                'response' => false,
                'message' => 'Role not found'
            ]);
        }
        

        if(!empty($user)){

            $user->assignRole($role);

            return response()->json([
                'response' => true,
                'token' => 'Rol agg'
            ]);


        }else{
            
            return response()->json([
                'response' => false,
                'token' => "User no found"
            ]);
        }

       
    }

    public function deleteRole(Request $request){

        //$this->validateaggRole($request);

        $user = User::where('nit', $request->nit)->first();
        $role = Role::where('name', $request->name )->first();



        if(empty($role)){
            return response()->json([
                'response' => false,
                'message' => 'Role not found'
            ]);
        }
        

        if(!empty($user)){

            $user->removeRole($role);

            return response()->json([
                'response' => true,
                'token' => 'Rol delete'
            ]);


        }else{
            
            return response()->json([
                'response' => false,
                'token' => "User no found"
            ]);
        }


    }

    protected function validateaggRole(Request $request){

        $request->validate([

            'student_code' => 'required',
            'role' => 'required'

        ]);

    }


}
