<?php

namespace App\Imports;

use App\Http\Controllers\StorageController;
use App\Models\Proyecto;
use App\Models\Proyecto_User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

HeadingRowFormatter::default('none');


class ResumenImport implements ToModel,WithHeadingRow,WithValidation,WithChunkReading,WithBatchInserts,SkipsOnFailure
{

    use SkipsFailures;

    private $driveData;
    private $id;

    function __construct()
    {
        $this->driveData = new StorageController();
    }

    public function model(array $row)
    {
        $proyecto = 'RESUMEN';
        $data_name = Proyecto::where('name', $proyecto)->first();

        if(empty($data_name)) {
            $proyecto_id = Proyecto::create([
                'name' => $proyecto,
                'descripcion' => 'descripcion 1',
                'ubicacion' => 'calle 1'
            ]);

            $this->id = $proyecto_id->id;
        }



        /*CONTRATISTA*/
        $user_contratista = User::create([
            'nit' => $row['CEDULA REPRESENTANTE'],
            'name' => strtoupper($row['NOMBRE DEL REPRESENTANTE LEGAL']),
            'last_name' => strtoupper($row['APELLIDO DEL REPRESENTANTE LEGAL']),
            'email' => str_replace(' ', '', $row['CORREO REPRESENTANTE LEGAL']),
            'password' => Hash::make('12345'),
        ]);


        Proyecto_User::create([
            'user_nit' => $user_contratista->nit,
            'proyecto_id' => (empty($data_name)) ?  $this->id : $data_name->id,
        ]);

        $user_contratista->assignRole('Contratista');

        $this->driveData->createDirectory(strtoupper($user_contratista->name));


        /*AUXILIARES*/


        $user_hsq = User::create([
            'nit' => str_replace(' ', '', $row['CEDULA HSQ']),
            'name' => strtoupper($row['NOMBRE HSQ']),
            'last_name' => strtoupper($row['APELLIDO HSQ']),
            'email' => str_replace(' ', '', $row['CORREO HSQ ENCARGADO']),
            'password' => Hash::make('12345'),
        ]);

        Proyecto_User::create([
            'user_nit' =>  $user_hsq->nit,
            'proyecto_id' => (empty($data_name)) ?  $this->id : $data_name->id,
        ]);

        $user_hsq->assignRole('Aux');
        $this->driveData->createDirectory(strtoupper($user_hsq->name));



    }

    public function rules(): array
    {
        return [
            'CEDULA REPRESENTANTE' => ['required','unique:users,nit'],
            'CORREO REPRESENTANTE LEGAL' => ['required','unique:users,email'],
            'NOMBRE DEL REPRESENTANTE LEGAL' => ['required','unique:users,name'],
            'CEDULA HSQ' => ['required','unique:users,nit'],
            'CORREO HSQ ENCARGADO' => ['required','unique:users,email'],
            'NOMBRE HSQ' => ['required','unique:users,name'],
        ];
    }


    public function headingRow(): int
    {
        return 3;
    }

    public function batchSize(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

}
