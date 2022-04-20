<?php

namespace App\Http\Controllers;

use App\Imports\HsqImport;
use App\Imports\UsersImport;
use App\Mail\TestMail;
use App\Models\File;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Mail;
use RealRashid\SweetAlert\Facades\Alert;
use ZipArchive;

class ContratistaController extends Controller
{

    public function index()
    {
        return view('dash.coordinador.listFiles');
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
            ->where('users.nit', '=', $nit)
            ->where('files.proyecto_id', $proyecto->id)
            ->distinct()
            ->get();

        $JString = json_encode($data);
        echo $JString;
        return;
    }

    public function showProyecto($name)
    {

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

        return view('dash.contratista.listProyecto')->with(compact('name', 'dataFiles'));
    }

    public function report()
    {
        $arrayData = $_POST['data'];
        $name = $_POST['proyecto'];


        $user = User::select('users.email', 'users.name', 'users.last_name')->role('Aux')
            ->join('proyecto_users', 'proyecto_users.user_nit', '=', 'users.nit')
            ->join('proyectos', 'proyecto_users.proyecto_id', '=', 'proyectos.id')
            ->where('proyectos.name', $name)
            ->get();


        for ($k = 0; $k < count($user); $k++) {

            try {
                Mail::to($user[$k]->email)->send(new TestMail($arrayData));

                return [
                    'response' => true,
                    'message' => 'Reporte Enviado!'
                ];
            } catch (\Exception $e) {

                return [
                    'response' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
    }

    public function dowloandFile($archivo)
    {

        $propietario = auth()->user()->name;
        $path = storage_path() . '/' . 'app' . '/' . $propietario . '/' . $archivo;
        if (file_exists($path)) {
            return Response::download($path);
        } else {
            Alert::warning('Opps!', 'Archivo no encontrado');
            return back();
        }
    }

    public function viewUploadUsers()
    {
        return view('dash.coordinador.uploadUsuarios');
    }

    public function uploadUsers(Request $request)
    {

        $var1 = $request->input('optradio');
        try {

            $file = $request->file('file');
            $name = $file->getClientOriginalName();


            if (strcmp($name, 'contratista.xlsx') === 0) {
                Log::debug($var1);

                $import = new UsersImport();

                $import->import($file);

                if ($import->failures()->isNotEmpty()) {

                    return back()->withFailures($import->failures()->sort());
                }

                Alert::success('Carga de datos excel', 'informacion guardada');
                return back();
            } else if (strcmp($name, 'hsq.xlsx') === 0) {
                Log::debug($var1);

                $import = new HsqImport();

                $import->import($file);
                //dd($import->failures());

                if ($import->failures()->isNotEmpty()) {

                    return back()->withFailures($import->failures()->sort());
                }

                Alert::success('Carga de datos excel', 'informacion guardada');
                return back();
            }else{
                Alert::error('Error', 'Verifique los nombres de los formatos');
                return back();
            }

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {

            return back()->withFailures($e->failures());

        } catch (\ErrorException $e) {
            Alert::error('Error', 'Seleccione el item Adecuado');
            return back();
        }
    }


    protected function downloadFile($src)
    {
        if (is_file($src)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $content_type = finfo_file($finfo, $src);
            finfo_close($finfo);
            $file_name = basename($src) . PHP_EOL;
            $size = filesize($src);
            header("Content-Type: $content_type");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: $size");
            readfile($src);
            return true;
        } else {
            return false;
        }
    }

    public function formato()
    {
        $files = array("contratista.xlsx", "hsq.xlsx");
        $zip = new ZipArchive();
        $zip_name = time() . ".zip"; // Zip name
        $zip->open($zip_name, ZipArchive::CREATE);
        foreach ($files as $file) {
            $path = app_path() . "/Files/formato/" . $file;
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
