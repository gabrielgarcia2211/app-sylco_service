<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class UsersImport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'JAZMINES' =>  new JazminesImport(),
           // 'TERRAS' =>  new TerrasImport(),
           // 'RESUMEN' =>  new ResumenImport(),
        ];
    }
}