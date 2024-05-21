<?php

namespace App\Imports;

use App\Models\csvDevis;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DevisImport implements ToModel,WithHeadingRow
{
    public function model(array $row)
    {
        return new csvDevis([
            //
        ]);
    }
}
