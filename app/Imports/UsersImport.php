<?php

namespace App\Imports;

use App\Imports\JazminesImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements WithMultipleSheets
{
    use Importable;

    public function sheets(): array
    {
        return [
            'JAZMINES' =>  new JazminesImport(),
            'TERRAS' =>  new TerrasImport(),
            'RESUMEN' =>  new ResumenImport(),
        ];
    }
}
