<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Storage;

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
                
                for($i = 0; $i < count($ruta); $i++){
                    $path = $nombre.'/'.$ruta[$i];
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
                $extension = pathinfo($nombre, PATHINFO_EXTENSION);


                $nombreFi = $name .'.' . $extension;

                //indicamos que queremos guardar un nuevo archivo en el disco local
                Storage::put($carpetaPadre . '/' . $name .'.' . $extension,  \File::get($file));
    

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

                if (Storage::exists($carpetaPadre. '/' .$filename)) {
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

        $zip = new ZipArchive();
        // Ruta absoluta
        $nombreArchivoZip = __DIR__ . "/4-directorio.zip";
        $rutaDelDirectorio = __DIR__ . "/imágenes";

        if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            exit("Error abriendo ZIP en $nombreArchivoZip");
        }
        // Si no hubo problemas, continuamos

        // Crear un iterador recursivo que tendrá un iterador recursivo del directorio
        $archivos = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rutaDelDirectorio),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($archivos as $archivo) {
            // No queremos agregar los directorios, pues los nombres
            // de estos se agregarán cuando se agreguen los archivos
            if ($archivo->isDir()) {
                continue;
            }

            $rutaAbsoluta = $archivo->getRealPath();
            // Cortamos para que, suponiendo que la ruta base es: C:\imágenes ...
            // [C:\imágenes\perro.png] se convierta en [perro.png]
            // Y no, no es el basename porque:
            // [C:\imágenes\vacaciones\familia.png] se convierte en [vacaciones\familia.png]
            $nombreArchivo = substr($rutaAbsoluta, strlen($rutaDelDirectorio) + 1);
            $zip->addFile($rutaAbsoluta, $nombreArchivo);
        }
        // No olvides cerrar el archivo
        $resultado = $zip->close();
        if ($resultado) {
            echo "Archivo creado";
        } else {
            echo "Error creando archivo";
        }

        log::debug();
        return;
        $nombreAmigable = "backup.zip";
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=$nombreAmigable");

        readfile($nombreArchivoZip);

        unlink($nombreArchivoZip);
    }
}
