<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;

class StorageController extends Controller
{
    //CREAR UN DIRECTORIO PRINCIPAL
    public function createDirectory($nombre = "")
    {
        $ruta = array(
            'CERTIFICACION ARL SG-SST',
            'MANUAL DEL SG SST',
            'HV',
            'INDUCCION Yo REINDUCCION',
            'CONDICIONES DE SALUD',
            'DOTACION Y EPP',
            'REGLAMENTOS',
            'AFI SS',
            'CAPACITACIONES',
            'INSPECCIONES',
            'INV AT-EL',
            'COPASST',
            'COVILA',
            'NOTIFICACIONES DE SEGURIDAD',
            'INFORMES MENSUALES',
            'MATRIZ IPEVR',
            'ALTO RIESGO',
            'PLAN DE EMERGENCIAS',
            'PAPSO',
            'REVISION DOCUMENTAL'
        );

        try {

            if (!Storage::exists($nombre)) {

                Storage::makeDirectory($nombre);

                for ($i = 0; $i < count($ruta); $i++) {
                    $path = $nombre . '/' . $ruta[$i];
                    Storage::makeDirectory($path, 0755, true, true);
                }

                return [
                    'response' => true,
                    'message' => 'Usuario Creado'
                ];
            } else {

                return [
                    'response' => false,
                    'message' => 'Nombre de Usuario ya Existe'
                ];
            }
        } catch (Exception $e) {

            return [
                'response' => false,
                'message' =>  $e->getMessage()
            ];
        }
    }


    public function findDirectory($folder)
    {

        if (Storage::exists($folder)) {
            return true;
        } else {
            return false;
        }
    }


    //EDITAR DIRECTORIO (PADRE O HIJO)
    public function editDirectory($carpetaPadre = "", $name = "")
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                Storage::rename($carpetaPadre, $name);

                return [
                    'response' => true,
                    'message' => 'Directorio Actualizado (PADRE)'
                ];
            } else {

                return [
                    'response' => false,
                    'message' => 'El Directorio no Existe (PADRE)'
                ];
            }
        } catch (Exception $e) {
            return [
                'response' => false,
                'message' =>  $e->getMessage()
            ];
        }
    }


    //GUARDAR ARCHIVOS EN DIRECTORIOS (PADRE O HIJO)
    public function putFile($carpetaPadre, $file, $name)
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                //obtenemos el nombre del archivo
                $nombre = $file->getClientOriginalName();
                #$name = $nombre;
                $extension = pathinfo($nombre, PATHINFO_EXTENSION);


                $nombreFi = $name . '.' . $extension;

                //indicamos que queremos guardar un nuevo archivo en el disco local
                Storage::put($carpetaPadre . '/' . $name . '.' . $extension,  File::get($file));


                return [
                    'response' => true,
                    'message' =>  $nombreFi
                ];
            } else {

                return [
                    'response' => false,
                    'message' => 'El Directorio no Existe (USUARIO)'
                ];
            }
        } catch (Exception $e) {
            return [
                'response' => false,
                'message' =>  $e->getMessage()
            ];
        }
    }


    //ELIMINAR DIRECTORIO(PADRE)
    public function deleteFile($carpetaPadre, $filename,  $tipo = 4)
    {
        /** 
         *  1 -> Archivo
         *  2 -> Carpeta(usuario)
         */
        switch ($tipo) {
            case 1:
                $dataPadre = $this->findDirectory($carpetaPadre);

                if (!$dataPadre) {
                    return [
                        'response' => false,
                        'message' => 'El Directorio no Existe (PADRE)'
                    ];
                }

                if (Storage::exists($carpetaPadre . '/' . $filename)) {
                    Storage::delete($carpetaPadre . '/' . $filename);
                    return [
                        'response' => true,
                        'message' => 'Archivo eliminado'
                    ];
                } else {
                    return [
                        'response' => false,
                        'message' => 'Archivo no encontrado'
                    ];
                }


                break;
            case 2:
                $dataPadre = $this->findDirectory($carpetaPadre);

                if ($dataPadre) {
                    Storage::deleteDirectory($carpetaPadre);
                    return [
                        'response' => true,
                        'message' => 'El Directorio Eliminado (PADRE)'
                    ];
                } else {
                    return [
                        'response' => false,
                        'message' => 'El Directorio no Existe (PADRE)'
                    ];
                }
                break;
            default:
                return [
                    'response' => false,
                    'message' => 'Error, No se Encontro el Directorio'
                ];
        }
    }

    public function backup()
    {

        $name = "app" . "/" .auth()->user()->name;

        $zip = new ZipArchive;

        $fileName = date("Y-m-d") . '_backup.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::allFiles(storage_path($name));

            foreach ($files as $key => $value) {
                $zip->addFile($value, auth()->user()->name . "/" . $value->getRelativePathname());
            }

            $zip->close();
        }

        return response()->download(public_path($fileName))->deleteFileAfterSend(true);;

    }
}
