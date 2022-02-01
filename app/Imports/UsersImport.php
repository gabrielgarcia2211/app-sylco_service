<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');


class UsersImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $_SESSION['data'] =  $row['PRIMER APELLIDO'];
    }
}
