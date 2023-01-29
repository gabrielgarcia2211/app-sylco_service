<?php

namespace App\Http\Controllers;

use Exception;
use ZipArchive;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    //CREAR UN DIRECTORIO PRINCIPAL
    public function createDirectory($nombre = "", $proyecto = "")
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

            $uuid = "usuario_" . uniqid();
            $init = $proyecto . "/" . $uuid;

            if (!Storage::exists($init)) {

                Storage::makeDirectory($init);

                for ($i = 0; $i < count($ruta); $i++) {
                    $path = $init . '/' . $ruta[$i];
                    Storage::makeDirectory($path, 0755, true, true);
                }

                return [
                    'response' => true,
                    'uuid' => $uuid,
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

        try {
            $name = "app";

            $zip = new ZipArchive;

            $fileName = date("Y-m-d") . '_backup.zip';

            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
                $files = File::allFiles(storage_path($name));

                foreach ($files as $key => $value) {

                    $zip->addFile($value, auth()->user()->name . "/" . $value->getRelativePathname());
                    $temp_name = explode('\\', $value->getRelativePathname());

                    $cadenab_proyecto = 'proyecto_';
                    $cadenab_users = 'usuario_';
                    for ($i = 0; $i < count($temp_name); $i++) {
                        $posicion_proyecto = strpos($temp_name[$i], $cadenab_proyecto);
                        if ($posicion_proyecto === 0) {
                            $k = 0;
                            $item_name = "";
                            while ($item_name = $zip->getNameIndex($k)) {
                                $zip->renameIndex($k, str_replace($temp_name[$i], self::getProyecto($temp_name[$i]), $item_name));
                                $k++;
                            }
                        }
                        $posicion_users = strpos($temp_name[$i], $cadenab_users);
                        if ($posicion_users === 0) {
                            $p = 0;
                            $item_name = "";
                            while ($item_name = $zip->getNameIndex($p)) {
                                $zip->renameIndex($p, str_replace($temp_name[$i], self::getuser($temp_name[$i]), $item_name));
                                $p++;
                            }
                        }
                        if ($i == count($temp_name) - 1) {
                            $u = 0;
                            $item_name = "";
                            while ($item_name = $zip->getNameIndex($u)) {
                                $zip->renameIndex($u, str_replace($temp_name[$i], self::getFile($temp_name[$i], $value->getExtension()), $item_name));
                                $u++;
                            }
                        }
                    }
                }

                $zip->close();
            }

            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            return [
                'response' => false,
                'message' => 'Error'
            ];
        }
    }

    public function allRemove()
    {
        $id = auth()->user()->id;

        $files = FileModel::select('files.*')
            ->join('file_users', 'file_users.file_id', 'files.id')
            ->join('users', 'file_users.user_nit', 'users.nit')
            ->where('users.id', $id)
            ->get();

        try {
            foreach ($files as $file) {
                $flight = FileModel::find($file->id);
                $data = $this->deleteFile($file->ruta, $file->file, 1);
                if ($data['response']) {
                    $flight->delete();
                } else {
                    return [
                        'response' => false,
                        'message' =>  'Archivo no encontrado, Elimina manualmente: ' . " " .  $file->ruta
                    ];
                }
            }
            DB::commit();
            return [
                'response' => true,
                'message' =>  'Archivos eliminados'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    # NUEVOS CAMBIOS 
    public function deleteFileV2($path)
    {

        try {
            Storage::deleteDirectory($path);
            return [
                'response' => true,
                'message' => 'El Directorio Eliminado (PADRE)'
            ];
        } catch (Exception $e) {

            return [
                'response' => false,
                'message' =>  $e->getMessage()
            ];
        }
    }

    private function getProyecto($name)
    {
        return Proyecto::select('name')->where('uuid', $name)->get()->toArray()[0]["name"];
    }

    private function getUser($name)
    {
        return User::select('name')->where('uuid', $name)->get()->toArray()[0]["name"];
    }

    private function getFile($name, $ext)
    {
        return FileModel::select('name')->where('file', $name)->get()->toArray()[0]["name"] . ".".$ext;
    }
}
