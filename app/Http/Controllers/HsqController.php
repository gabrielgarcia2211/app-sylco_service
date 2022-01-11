<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Proyecto;
use App\Mail\NotificacionMail;
use Mail;


class HsqController extends Controller
{

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
}
