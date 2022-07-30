<?php

namespace App\Http\Controllers;

use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PruebaController extends Controller
{

    function index(){

        $arra = [];

        foreach (new DirectoryIterator('D:\Programas\obs-studio') as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            echo array_push($arra, $fileInfo->getFilename());
        }

        Log::debug('hola');

        $this->formato($arra);
    }

    public function formato($arra)
    {
        $files = $arra;
        $zip = new ZipArchive();
        $zip_name = time() . ".zip"; // Zip name
        $zip->open($zip_name, ZipArchive::CREATE);
        foreach ($files as $file) {
            $path = storage_path() . '/' . 'app';
            if (file_exists($path)) {
                $zip->addFromString(basename($path), file_get_contents($path));
            } else {
                echo "file does not exist";
            }
        }
        $zip->close();
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zip_name);
        header('Content-Length: ' . filesize($zip_name));
        readfile($zip_name);
        //$this->downloadFile(app_path()."/Files/formato/hsq.xlsx");
    }

}
