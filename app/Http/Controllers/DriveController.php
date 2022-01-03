<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;
use Mail;

class DriveController extends Controller
{
    //CREAR UN DIRECTORIO PRINCIPAL
    public function createDirectory($nombre = "")
    {

        try {

            if (!$this->findDirectory($nombre)) {

                Storage::disk('google')->makeDirectory($nombre);

                return [
                    'response' => true,
                    'message' => 'Usuario Creado'
                ];
            } else {

                return [
                    'response' => false,
                    'message' => 'El Usuario ya Existe'
                ];
            }
        } catch (Exception $e) {

            return [
                'response' => false,
                'message' =>  $e->getMessage()
            ];
        }
    }


    //ENCONTRAR UN DIRECTORIO (PADRE O HIJO)
    public function findDirectory($folder, $dir = '/')
    {

        $recursive = false;
        $contents = collect(Storage::disk('google')->listContents($dir, $recursive));


        $dir = $contents->where('type', '=', 'dir')
            ->where('filename', '=', $folder)
            ->first();

        if (!$dir) {
            return false;
        }

        return $dir;
    }


    //GUARDAR ARCHIVOS EN DIRECTORIOS (PADRE O HIJO)
    public function putFile($carpetaPadre = "hola", $file = "test.txt", $name)
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                Storage::disk('google')->put($dataPadre['path'] . '/' . $name, $file);

                $files = collect(Storage::disk('google')
                    ->listContents($dataPadre['path'], false))
                    ->where('filename', '=', '' . $name)
                    ->where('type', '=', 'file');


                $dataJson = array();

                foreach ($files as &$file) {
                    array_push($dataJson, [$file['name'], Storage::disk('google')->url($file['path'])]);
                }

                return [
                    'response' => true,
                    'message' =>  $dataJson
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
    public function deleteFile($carpetaPadre = "hola", $filename,  $tipo = 4)
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

                $contents = collect(Storage::disk('google')->listContents($dataPadre['path'], false));

                $file = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first();

                if (!$file) {
                    return [
                        'response' => false,
                        'message' => 'Archivo no encontrado'
                    ];
                } else {
                    Storage::disk('google')->delete($file['path']);
                    return [
                        'response' => true,
                        'message' => 'Archivo eliminado'
                    ];
                }

                break;
            case 2:
                $dataPadre = $this->findDirectory($carpetaPadre);

                if ($dataPadre) {
                    Storage::disk('google')->deleteDirectory($dataPadre['path']);
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


    //EDITAR DIRECTORIO (PADRE O HIJO)
    public function editDirectory($carpetaPadre = "/", $name = "")
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                //dd($dataPadre['path']);
                Storage::disk('google')->move($dataPadre['path'], $name);

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


    public function getMail($data = "hola")
    {
        $data = [
            "name" => 'gabriel',
            "message" => 'message',
            "asunto" => 'prueba'
        ];
        Mail::to('garciaquinteroga@gmail.com')->send(new TestMail($data)); //aca se cambie por el remitente
    }



    //NO UTIL

    //CREAR UN SUB DIRECTORIO 
    public function createSubDirectory($carpetaPadre = "", $carpetaHijo = "")
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {
            if ($dataPadre) {

                if (!$this->findDirectory($carpetaHijo, $dataPadre['path'])) {

                    Storage::disk('google')->makeDirectory($dataPadre['path'] . '/' . $carpetaHijo);

                    return [
                        'response' => true,
                        'message' => 'Directorio Creado (HIJO)'
                    ];
                } else {
                    return [
                        'response' => false,
                        'message' => 'El Directorio ya Existe (HIJO)'
                    ];
                }
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

    //LISTAR DIRECTORIOS (PADRE O HIJO)
    public function listDirectory($carpetaPadre = "")
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                $files = collect(Storage::disk('google')
                    ->listContents($dataPadre['path'], false))
                    ->where('type', '=', 'file');


                $dataJson = array();
                foreach ($files as &$file) {
                    array_push($dataJson, [$file['name'], Storage::disk('google')->url($file['path'])]);
                }

                return [
                    'response' => true,
                    'message' =>  $dataJson
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
}
