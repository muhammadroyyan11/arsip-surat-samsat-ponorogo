<?php

namespace App\Imports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PositionsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return Position::updateOrCreate(
            ['name' => $row['nama_jabatan']]
        );
    }
}
