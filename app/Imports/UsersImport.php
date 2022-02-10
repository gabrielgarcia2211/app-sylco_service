<?php

namespace App\Imports;

use App\Imports\JazminesImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements WithMultipleSheets
{
    use Importable;

    private $sheets;
    private $fail = array();

    public function sheets(): array
    {
        $this->sheets = [
            0 =>  new JazminesImport(),
        ];

        return $this->sheets;
    }

    public function failures()
    {
        foreach($this->sheets as $sheet)
        {
            array_push($this->fail, $sheet->failures());

        }

        return $this->fail;
    }
}
