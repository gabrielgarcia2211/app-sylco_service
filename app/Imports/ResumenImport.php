<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;



HeadingRowFormatter::default('none');

class ResumenImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts
{

    public function model(array $row)
    {
        User::create([
            'nit' => str_replace(' ', '', $row["CEDULA REPRESENTANTE"]),
            'name' => str_replace(' ', '', $row['NOMBRE DEL REPRESENTANTE LEGAL']),
            'last_name' => str_replace(' ', '', $row['APELLIDO DEL REPRESENTANTE LEGAL']),
            'email' => str_replace(' ', '', $row['CORREO REPRESENTANTE LEGAL']),
            'password' => Hash::make('12345'),
        ]);
    }

    public function rules(): array
    {
        return [
            'CEDULA REPRESENTANTE' => 'required|unique:users,nit',
            'CORREO REPRESENTANTE LEGAL' => 'required|unique:users,email',
            'NOMBRE DEL REPRESENTANTE LEGAL' => 'required|string',
            'APELLIDO DEL REPRESENTANTE LEGAL' => 'required|string',
        ];
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function headingColumn(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
