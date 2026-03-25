<?php

namespace App\Imports;

use App\Models\Division;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DivisionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Division::updateOrCreate(
            ['name' => $row['nama_divisi']]
        );
    }
}
