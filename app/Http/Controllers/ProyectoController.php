<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use App\Models\Proyecto_User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\File;

class ProyectoController extends Controller
{

    public function index()
    {
        $dataProyecto = Proyecto::where('status', 0)->get();
        return view('dash.coordinador.listProyecto')->with(compact('dataProyecto'));
    }

    public function indexStore()
    {
        $JString = "";
        return view('dash.coordinador.addProyecto')->with(compact('JString'));
    }

    public function store(Request $request)
    {

        $this->validateStore($request);
        $dataProyecto = Proyecto::where('name', strtoupper($request->nombre))->where('status', 0)->first();

        if (empty($dataProyecto)) {

            try {

                $uuid = "proyecto_" . uniqid();

                Proyecto::create([
                    'name' =>  strtoupper($request->nombre),
                    'uuid' =>  $uuid,
                    'descripcion' =>  $request->descripcion,
                    'ubicacion' =>  $request->ubicacion,
                ]);

                Storage::makeDirectory($uuid);

                return [
                    'response' => true,
                    'message' => 'Proyecto Creado!'
                ];
            } catch (\Exception $e) {
                return [
                    'response' => false,
                    'message' => $e->getMessage()
                ];
            }
        } else {

            return [
                'response' => false,
                'message' => 'El Proyecto ya Existe!'
            ];
        }
    }

    protected function validateStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
        ]);
    }

    public function edit()
    {

        $name = $_POST['name'];
        $descripcion = $_POST['descripcion'];
        $ubicacion = $_POST['ubicacion'];
        $id = $_POST['id'];

        $dataProyecto = Proyecto::where('name', strtoupper($name))->first();
        $proyect = Proyecto::find($id);


        if (!empty($dataProyecto) && $name != $proyect->name) {
            return [
                'response' => false,
                'message' => 'El Proyecto ya Existe!'
            ];
        }

        if (empty($proyect)) {

            return [
                'response' => false,
                'message' => 'Proyecto no Encontrado'
            ];
        }

        try {

            $proyect->name =  $name;
            $proyect->descripcion =  $descripcion;
            $proyect->ubicacion =  $ubicacion;

            $proyect->update();

            return [
                'response' => true,
                'message' => 'Proyecto Actualizado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete()
    {
        $nombre = $_POST['search'];

        try {

            $proyecto = Proyecto::where('name', $nombre)->first();
            $files = User::select('files.id', 'files.file')
                ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
                ->join('files', 'files.id', '=', 'file_users.file_id')
                ->where('files.proyecto_id', $proyecto->id)
                ->get()->toArray();


            Storage::deleteDirectory($proyecto->uuid);

            for ($i = 0; $i < count($files); $i++) {
                File::where('id', $files[$i]['id'])->delete();
            }

            $proyecto->delete();

            return [
                'response' => true,
                'message' =>  'Proyecto eliminado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function indexFindProyecto()
    {
        return view('dash.coordinador.vincularProyecto');
    }

    public function FindProyecto()
    {

        if (!empty($_POST['usuario'])) {

            $id = $_POST['usuario'];

            $user = User::where('nit', $id)->first();

            if (empty($user)) {

                Alert::error('Opps!', 'Usuario no Registrado');
                return back();
            }

            $userAdd = Proyecto::select('proyectos.name')
                ->join('proyecto_users', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
                ->join('users', 'users.nit', '=', 'proyecto_users.user_nit')
                ->where('proyectos.status', '=',  '0')
                ->where('users.nit', '=',  $id)->get();


            $userDelete = DB::select("SELECT  DISTINCT proyectos.name FROM proyectos 
            LEFT JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
            LEFT JOIN users ON users.nit = proyecto_users.user_nit
            WHERE  proyectos.status = 0 AND proyectos.name  NOT IN
            ( SELECT  proyectos.name FROM proyectos
                INNER JOIN proyecto_users ON proyecto_users.proyecto_id = proyectos.id
                INNER JOIN users ON users.nit = proyecto_users.user_nit 
                WHERE users.nit = $id)");

            $JString = array();

            $JString = [
                'agregar' => $userDelete,
                'eliminar' => $userAdd
            ];

            return view('dash.coordinador.vincularProyecto')->with(compact('JString'));
        } else {

            Alert::warning('Opps!', 'Pro favor, Ingrese Nit');
            return back();
        }
    }

    public function vincularProyecto()
    {

        $proyecto =  $_POST['proyecto'];
        $nit = $_POST['nit'];

        try {

            $user = User::where('nit', $nit)->first();
            $proyecto = Proyecto::where('name', $proyecto)->where('status', 0)->first();

            Proyecto_User::create([
                'user_nit' =>    $user->nit,
                'proyecto_id' =>  $proyecto->id
            ]);

            $response = self::controlVinculados($user->uuid, true);

            $init = storage_path("app");

            if ($response["status"]) {
                self::recurse_copy(
                    $init . "/" . $response["proyecto"] . "/" . $user->uuid,
                    $init . "/" . $proyecto->uuid . "/" . $user->uuid
                );
            } else {
                $new_path = "desvinculados";
                Storage::move($new_path . "/" . $user->uuid, $proyecto->uuid . "/" . $user->uuid);
            }

            return [
                'response' => true,
                'message' =>  'Proyecto vinculado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function desvincularProyecto()
    {
        $proyecto =  $_POST['proyecto'];
        $nit = $_POST['nit'];

        try {

            $user = User::where('nit', $nit)->first();
            $proyecto = Proyecto::where('name', $proyecto)->where('status', '0')->first();
            Proyecto_User::where('user_nit', $user->nit)->where('proyecto_id', $proyecto->id)->delete();
            $response = self::controlVinculados($user->uuid);
            if ($response == 1) {
                $new_path = "desvinculados";
                $init = storage_path("app");
                if (!Storage::exists($new_path)) {
                    Storage::makeDirectory($new_path, 0755, true, true);
                }
                self::recurse_copy($init . "/" . $proyecto->uuid . "/" . $user->uuid, $init . "/" . $new_path . "/" . $user->uuid);
                Storage::deleteDirectory($proyecto->uuid . "/" . $user->uuid);
            } else {
                Storage::deleteDirectory($proyecto->uuid . "/" . $user->uuid);
            }

            $files = User::select('files.id', 'files.file')
                ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
                ->join('files', 'files.id', '=', 'file_users.file_id')
                ->where('files.proyecto_id', $proyecto->id)
                ->get()->toArray();

            for ($i = 0; $i < count($files); $i++) {
                File::where('id', $files[$i]['id'])->delete();
            }

            return [
                'response' => true,
                'message' =>  'Proyecto desnviculado'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function controlVinculados($user_uuid, $vincular = false)
    {
        $proyect = Proyecto::where('status', 0)->get()->toArray();
        if (!$vincular) {
            $cont = 0;
            for ($i = 0; $i < count($proyect); $i++) {
                if (Storage::exists($proyect[$i]["uuid"] . "/" . $user_uuid)) {
                    $cont++;
                }
            }
            return $cont;
        } else {

            for ($i = 0; $i < count($proyect); $i++) {
                if (Storage::exists($proyect[$i]["uuid"] . "/" . $user_uuid)) {
                    return [
                        "status" => true,
                        "proyecto" => $proyect[$i]["uuid"]
                    ];
                }
            }

            return [
                "status" => false,
                "proyecto" => null
            ];
        }
    }

    private function recurse_copy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    self::recurse_copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
