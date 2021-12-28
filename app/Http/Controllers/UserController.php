<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Proyecto_User;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;


class UserController extends Controller
{
    public function index()
    {
        $dataProyecto = Proyecto::all(['id','name']);
        $dataUser = User::select('users.nit', 'users.name', 'users.last_name', 'users.email' , 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId')
        ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
        ->join('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')->get();
        return view('dash.coordinador.listUsuario')->with(compact('dataUser', 'dataProyecto'));
    }

    public function indexStore()
    {
        $dataRol = Role::all(['name']);
        $dataProyecto = Proyecto::all(['name']);
        return view('dash.coordinador.addUsuario')->with(compact('dataRol', 'dataProyecto'));
    }

    public function store(Request $request)
    {

        $this->validateStore($request);

        $role = Role::where('name', $request->rol)->first();
        $proyecto = Proyecto::where('name', $request->proyecto)->first();

        if (empty($role)) {
            Alert::success('Opss', 'Error!');
            return redirect()->back();
        }

        try {
            
            $user = User::create([
                'nit' =>  $request->nit,
                'name' =>  strtoupper($request->nombre),
                'last_name' =>  strtoupper($request->apellido),
                'email' =>  $request->correo,
                'password' => Hash::make($request->contrasenia),
                'role' =>  $request->rol
            ]);

            Proyecto_User::create([
                'user_nit' =>    $request->nit,
                'proyecto_id' =>  $proyecto->id
            ]);


            $user->assignRole($role);

            Alert::success('Usario Creado', 'Hecho!');
            return redirect()->back();

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    protected function validateStore(Request $request)
    {
        $request->validate([
            'nit' => 'required|integer|unique:users,nit',
            'apellido' => 'required',
            'correo' => 'required|unique:users,email',
            'contrasenia' => 'required',
            'nombre' => 'required',
            'rol' => 'required'
        ]);
    }

    public function edit()
    {
        $nuevoId = $_POST['nuevoId'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $nit = $_POST['nit'];
        $nuevoProyecto = $_POST['nuevoProyecto'];
        $antProyecto = $_POST['antProyecto'];


        $userNuevo = User::where('nit', '=',  $nuevoId)->first();
        if(!empty($userNuevo) && $nuevoId != $nit){
            return [
                'response' => false,
                'message' => 'Nit ya Existe!'
            ];
        }
        $user = User::where('nit', '=',  $nit)->first();
        if (empty($user)) {

            return [
                'response' => false,
                'message' => 'Usuario no Encontrado'
            ];
        }

        try {

            $user->nit = $nuevoId;
            $user->last_name = strtoupper($apellido);
            $user->email = $correo;
            $user->name = strtoupper($nombre);


            //$findProyecto = Proyecto::find($nuevoProyecto)->fisrt();

            $findUserp = Proyecto_User::where('user_nit','=' , $nit)->where('proyecto_id','=' , $antProyecto)->first();

            $findUserp->user_nit = $nuevoId;
            $findUserp->proyecto_id = $nuevoProyecto;

            
            $user->update();
            $findUserp->update();

            return [
                'response' => true,
                'message' => 'Usuario Actualizado!'
            ];

        } catch (\Exception $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy()
    {


        $id = $_POST['search'];


        return [
            'response' => true,
            'message' =>   $id
        ];


        /*$carp = $this->driveData->deleteFile(strtoupper($nombre),  "/", "", 2);

        try {
            if ($carp['response']) {

                $user = User::where('nit', '=',  $nombre)->first();

                $proyect->delete();
                return [
                    'response' => true,
                    'message' =>  'Proyecto eliminado'
                ];
            }
            return [
                'response' => false,
                'message' =>  "Proyecto no registrado!"
            ];
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                'response' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

        if (empty($user)) {
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
        }*/
    }


    //-------------------------------------

    public function aggRole(Request $request)
    {

        //$this->validateaggRole($request);

        $user = User::where('nit', $request->nit)->first();
        $role = Role::where('name', $request->name)->first();



        if (empty($role)) {
            return response()->json([
                'response' => false,
                'message' => 'Role not found'
            ]);
        }


        if (!empty($user)) {

            $user->assignRole($role);

            return response()->json([
                'response' => true,
                'token' => 'Rol agg'
            ]);
        } else {

            return response()->json([
                'response' => false,
                'token' => "User no found"
            ]);
        }
    }

    public function deleteRole(Request $request)
    {

        //$this->validateaggRole($request);

        $user = User::where('nit', $request->nit)->first();
        $role = Role::where('name', $request->name)->first();



        if (empty($role)) {
            return response()->json([
                'response' => false,
                'message' => 'Role not found'
            ]);
        }


        if (!empty($user)) {

            $user->removeRole($role);

            return response()->json([
                'response' => true,
                'token' => 'Rol delete'
            ]);
        } else {

            return response()->json([
                'response' => false,
                'token' => "User no found"
            ]);
        }
    }

    protected function validateaggRole(Request $request)
    {

        $request->validate([

            'student_code' => 'required',
            'role' => 'required'

        ]);
    }
}
