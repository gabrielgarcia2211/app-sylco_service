<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class UsersImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'Hoja2' =>  new SecondSheetImport(),
            'Hoja1' =>  new FSheetImport(),
           
        ];
    }
}

// use App\User;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Imports\HeadingRowFormatter;


// HeadingRowFormatter::default('none');


// class UsersImport implements ToModel, WithHeadingRow
// {

//     public function model(array $row)
//     {
//         $_SESSION['data'] =  $row['PRIMER APELLIDO'];
//     }
// }
