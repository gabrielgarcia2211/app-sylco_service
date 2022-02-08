<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class TerrasImport  implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        echo $row['ITEM'];
    }

    public function headingRow(): int
    {
        return 3;
    }

}