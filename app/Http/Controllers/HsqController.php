<?php

namespace App\Http\Controllers;

use Mail;
use App\Models\File;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\File_User;
use Illuminate\Http\Request;
use App\Mail\NotificacionMail;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Log;


class HsqController extends Controller
{

    private $driveData;

    function __construct()
    {
        $this->driveData = new StorageController();
    }

    public function index()
    {
        return view('dash.auxiliar.listFiles');
    }


    public function showProyecto($name)
    {

        $dataFiles = User::select('users.*', 'proyectos.name AS proyecto', 'proyectos.id AS proyectoId')->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')->join('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
            ->where('proyectos.name', $name)
            ->role('Contratista')
            ->distinct()
            ->get();



        return view('dash.auxiliar.listContratista')->with(compact('dataFiles', 'name'));
    }


    public function showFile()
    {
        $nit = $_POST['nit'];
        $proyecto = $_POST['proyecto'];

        $proyecto = Proyecto::where('name', $proyecto)->first();

        $data = User::select('files.*', 'file_users.date AS fecha', 'users.name AS propietario')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
            ->join('file_users', 'file_users.user_nit', '=', 'users.nit')
            ->join('files', 'files.id', '=', 'file_users.file_id')
            ->where('users.nit',  '=', $nit)
            ->where('files.proyecto_id', $proyecto->id)
            ->distinct()
            ->get();


        $JString = json_encode($data);
        echo $JString;
        return;
    }


    public function report()
    {
        $arraySend = [
            'name' =>  $_POST['name'],
            'descripcion' => $_POST['descripcion']
        ];

        $email = $_POST['email'];


        try {
            Mail::to($email)->send(new NotificacionMail($arraySend));

            return [
                'response' => true,
                'message' => 'Correo Enviado!'
            ];
        } catch (\Exception $e) {

            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    function uploadFile($name){

        $proyecto = Proyecto::where('name', $name)->first();

        $dataFiles = File::select('files.*')
        ->join('file_users', 'file_users.file_id', '=', 'files.id')
        ->join('users', 'users.nit', '=', 'file_users.user_nit')
        ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
        ->join('proyectos', 'proyectos.id', '=', 'proyecto_users.proyecto_id')
        ->where('users.nit', auth()->user()->nit)
        ->where('files.proyecto_id', $proyecto->id)
        ->distinct()
        ->get();



        return view('dash.auxiliar.listProyecto')->with(compact('dataFiles', 'name'));
    }

    public function store(Request $request)
    {

        $files = $request->file('archivo');
        $name = time() . random_int(0, 100);

        $nombreContratista = auth()->user()->name;
        $nitContratista = auth()->user()->nit;

        $nombreArchivo = $request->input('nombre');
        $descripcionArchivo =  $request->input('descripcion');
        $nombreProyecto =  $request->input('proyecto');
        $carpetaDestino = $request->input('carpeta');


        try {

            $ruta = $nombreContratista.'/'.$carpetaDestino;

            $file = $this->driveData->putFile($ruta, $files, $name);

            if ($file['response']) {


                $proyecto = Proyecto::where('name', $nombreProyecto)->first();


                $fileUp = File::create([
                    'name' =>  $nombreArchivo,
                    'name_drive' => $name,
                    'descripcion' =>  $descripcionArchivo,
                    'file' =>   $file['message'],
                    'proyecto_id' => $proyecto->id,
                    'aceptacion' =>  '0',
                    'ruta' => $ruta
                ]);


                File_User::create([
                    'user_nit' => $nitContratista,
                    'file_id' => $fileUp->id,
                    'date' => date('Y-m-d H:i:s')
                ]);

                return [
                    'response' => true,
                    'message' => 'Archivo subido!'
                ];
            } else {

                return [
                    'response' => false,
                    'message' =>  $file['message']
                ];
            }
        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function dowloandFile($archivo){

        log::debug($archivo);
        $propietario = auth()->user()->id;
        log::debug($propietario);
        $temp = User::join('file_users','file_users.user_nit','=','users.nit')->join('files','file_users.file_id','=','files.id')->where('users.id',$propietario)->where('files.file',$archivo)->get()->toArray();
        log::debug($temp);
        $path = storage_path() . '/' . 'app' . '/' . $temp[0]['ruta'] . '/' . $archivo;
        if (file_exists($path)) {
            return Response::download($path);
        }else{

            Alert::warning('Opps!', 'Archivo no encontrado');
            return back();
        }
    }


    public function dowloandFileContratista($archivo, $nombre){

        $propietario = User::where('users.name',$nombre)->get()->toArray();
        log::debug($propietario);
        $id = $propietario[0]['id'];
        log::debug($id);
        $temp = User::join('file_users','file_users.user_nit','=','users.nit')->join('files','file_users.file_id','=','files.id')->where('users.id',$id)->where('files.file',$archivo)->get()->toArray();
        log::debug($temp[0]['ruta']);
        $path = storage_path() . '/' . 'app' . '/' . $temp[0]['ruta'] . '/' . $archivo;
        if (file_exists($path)) {
            return Response::download($path);
        }else{

            Alert::warning('Opps!', 'Archivo no encontrado');
            return back();
        }
    }

}
