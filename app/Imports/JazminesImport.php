<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;


HeadingRowFormatter::default('none');

class JazminesImport implements ToModel, WithHeadingRow, WithValidation
{

    public function model(array $row)
    {
        User::create([
            'nit' => $row["CEDULA REPRESENTANTE"],
            'name' => $row['NOMBRE DEL REPRESENTANTE LEGAL'],
            'last_name' => $row['APELLIDO DEL REPRESENTANTE LEGAL'],
            'email' => $row['CORREO REPRESENTANTE LEGAL'],
            'password' => Hash::make('12345'),
        ]);
    }

    public function rules(): array
    {
        return [
            'CEDULA REPRESENTANTE' => 'required|unique:users,nit',
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
}
