<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\File;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Proyecto_User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new StorageController();
    }

    public function index()
    {
        $dataProyecto = Proyecto::select('name')->where('status', 0)->get();

        $dataUser = User::select('users.*', 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId', 'proyectos.uuid as Uuid')
            ->leftjoin('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->leftjoin('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
            ->where('proyectos.status', '0')
            ->role(['Contratista', 'Aux'])
            ->get();

        return view('dash.coordinador.listUsuario')->with(compact('dataUser', 'dataProyecto'));
    }

    public function indexStore()
    {
        $dataRol = Role::all(['name']);
        $dataProyecto = Proyecto::select('name')->where('status', 0)->get();
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
            $name_clean = str_replace(' ', '', strtolower($request->nombre));
            $dataUser = $this->driveData->findDirectory($proyecto->uuid . "/" . $name_clean);

            if (!empty($dataUser)) {
                return [
                    'response' => false,
                    'message' => 'Nombre de Usuario ya Existe'
                ];
            }

            if ($request->role == 'Contratista' || $request->role == 'Aux') {
                $response = $this->driveData->createDirectory($request->nombre, $proyecto->uuid);
            }

            if (!isset($response["uuid"])) {
                return [
                    'response' => false,
                    'message' => 'Nombre ya existe'
                ];
            }

            try {

                $user = User::create([
                    'nit' =>  $request->nit,
                    'name' =>  strtoupper($request->nombre),
                    'last_name' =>  strtoupper($request->apellido),
                    'email' =>  $request->correo,
                    'password' => Hash::make($request->contrasenia),
                    'role' =>  $request->rol,
                    'uuid' => $response["uuid"],
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

        if (!empty($dataUser) && $nombre != $user->name) {

            return [
                'response' => false,
                'message' => 'Nombre de Usuario ya Existe'
            ];
        }

        try {

            $user->nit = $nuevoId;
            $user->last_name = strtoupper($apellido);
            $user->email = $correo;
            $user->name = strtoupper($nombre);

            $user->update();

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

        $response = json_decode($_POST['user']);
        $user = User::where('nit', '=',  $response->nit)->first();

        if (empty($user)) {
            return [
                'response' => false,
                'message' => 'Usuario no Encontrado'
            ];
        }

        $files = User::select('files.id', 'files.file')
        ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
        ->join('files', 'files.id', '=', 'file_users.file_id')
        ->where('files.proyecto_id', $response->proyectoId )
        ->get()->toArray();


        if ($user->hasRole('Contratista') || $user->hasRole('Aux')) {

            $carp = $this->driveData->deleteFileV2($response->Uuid . "/" . $user->uuid);

            try {
                if ($carp['response']) {

                    Proyecto_User::where('user_nit', $user->nit)->where('proyecto_id', $response->proyectoId)->delete();

                    $proyecto = User::select('proyectos.uuid AS uuid')
                        ->leftjoin('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
                        ->leftjoin('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
                        ->where('proyecto_users.user_nit', '=', $response->nit)
                        ->get()->toArray();

                    if (count($proyecto) == 0) {
                        User::where('nit', $user->nit)->delete();
                    }

                    for ($i=0; $i < count($files); $i++) { 
                        File::where('id', $files[$i]['id'])->delete();
                    }

                    return [
                        'response' => true,
                        'message' =>  'Usuario eliminado'
                    ];
                }
                return [
                    'response' => false,
                    'message' =>  "Usuario no registrado!"
                ];
            } catch (\Exception $e) {

                return response()->json([
                    'response' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }
}
