<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class JazminesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        echo $row['NOMBRE Y APELLIDO DEL REPRESENTANTE LEGAL'];
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
