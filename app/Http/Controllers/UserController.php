<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Proyecto_User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\DriveController;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new DriveController();
    }


    public function index()
    {
        $dataProyecto = Proyecto::all(['id', 'name']);
        
        $dataUser = User::select('users.*', 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId')
            ->leftjoin('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->leftjoin('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
            ->role(['Contratista', 'Aux'])
            ->get();

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

        $respError = $this->validateStore($request);


        if (!$respError) {

            $role = Role::where('name', $request->role)->first();
            $proyecto = Proyecto::where('name', $request->proyecto)->first();


            if (empty($role) || empty($proyecto)) {
                return [
                    'response' => false,
                    'message' => 'Opps falta informacion!'
                ];
            }


            $dataUser = $this->driveData->findDirectory(strtoupper($request->nombre));


            if (!empty($dataUser)) {

                return [
                    'response' => false,
                    'message' => 'Nombre de Usuario ya Existe'
                ];
            }

            if ($request->role == 'Contratista' || $request->role == 'Aux') {
                $this->driveData->createDirectory(strtoupper($request->nombre));
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


                return [
                    'response' => true,
                    'message' => 'Usuario Creado'
                ];


            } catch (\Exception $e) {
                return [
                    'response' => false,
                    'message' => $e->getMessage()
                ];
            }
        } else {
            return $respError;
        }
    }

    protected function validateStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nit' => 'required|unique:users,nit',
            'apellido' => 'required',
            'correo' => 'required|unique:users,email',
            'contrasenia' => 'required',
            'nombre' => 'required',
            'role' => 'required',
            'proyecto' => 'required',
        ]);

        $error = $validator->getMessageBag()->toArray();

        if (empty($error)) {
            return false;
        } else {

            return response()->json(array(
                'success' => false,
                'message' => 'There are incorect values in the form!',
                'errors' =>  $error
            ), 422);
        }
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



        $user = User::where('nit', '=',  $nit)->first();


        if (empty($user)) {

            return [
                'response' => false,
                'message' => 'Usuario no Encontrado'
            ];
        }



        $userNuevo = User::where('nit', '=',  $nuevoId)->first();

        if (!empty($userNuevo) && $nuevoId != $nit) {
            return [
                'response' => false,
                'message' => 'Nit ya Existe!'
            ];
        }


        $userEmail = User::where('email', '=',  $correo)->first();


        if (!empty($userEmail) && $correo != $user->email) {
            return [
                'response' => false,
                'message' => 'Correo ya Existe!'
            ];
        }


        $dataUser = $this->driveData->findDirectory(strtoupper($nombre));

        if (!empty($dataUser) && $nombre != $user->name) {

            return [
                'response' => false,
                'message' => 'Nombre de Usuario ya Existe'
            ];
        }


        try {

            $findUserp = Proyecto_User::where('user_nit', '=', $nit)->where('proyecto_id', '=', $antProyecto)->first();
            $this->driveData->editDirectory($user->name, strtoupper($nombre));


            $user->nit = $nuevoId;
            $user->last_name = strtoupper($apellido);
            $user->email = $correo;
            $user->name = strtoupper($nombre);

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

        $nit = $_POST['nit'];


        $user = User::where('nit', '=',  $nit)->first();

        if (empty($user)) {

            return [
                'response' => false,
                'message' => 'Usuario no Encontrado'
            ];
        }

        if ($user->hasRole('Contratista') || $user->hasRole('Aux')) {
            $carp = $this->driveData->deleteFile(strtoupper($user->name), '' , 2);

            try {
                if ($carp['response']) {


                    $user->delete();

                    return [
                        'response' => true,
                        'message' =>  'Usuario eliminado'
                    ];
                }
                return [
                    'response' => false,
                    'message' =>  "Usuario no registrado!"
                ];
            } catch (\Illuminate\Database\QueryException $e) {

                return response()->json([
                    'response' => false,
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            try {

                $user->delete();

                return [
                    'response' => true,
                    'message' =>  'Usuario eliminado'
                ];
            } catch (\Illuminate\Database\QueryException $e) {

                return response()->json([
                    'response' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

}
