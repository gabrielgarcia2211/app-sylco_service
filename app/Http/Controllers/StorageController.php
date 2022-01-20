<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    //CREAR UN DIRECTORIO PRINCIPAL
    public function createDirectory($nombre = "")
    {

        try {

            if (!Storage::exists($nombre)) {

                Storage::makeDirectory($nombre);

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
    public function putFile($carpetaPadre = "hola", $file = "test.txt", $name)
    {

        $dataPadre = $this->findDirectory($carpetaPadre);

        try {

            if ($dataPadre) {

                Storage::put($carpetaPadre . '/' . $name, $file);


                $files = Storage::allFiles($carpetaPadre);



                $dataJson = array();

                foreach ($files as &$file) {
                    $nameTemp = explode('/', $file);
                    array_push($dataJson, [$file[0], $nameTemp[1]]);
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

                if (Storage::exists($filename)) {
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
}
