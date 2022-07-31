<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use ZipArchive;
use Illuminate\Support\Facades\File;

class PruebaController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zip = new ZipArchive;

        $fileName = 'mydata.zip';

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::allFiles(storage_path('app\USUARIO 1'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, "USUARIO 1/CERTIFICACION ARL SG-SST/" . $relativeNameInZipFile);
            }

            $zip->close();
        }

        return response()->download(public_path($fileName));
        
    }
}
