<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class UsersImport implements WithMultipleSheets, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function sheets(): array
    {
        return [
            'JAZMINES' =>  new JazminesImport(),
            // 'TERRAS' =>  new TerrasImport(),
            //   'RESUMEN' =>  new ResumenImport(),
        ];
    }
}
