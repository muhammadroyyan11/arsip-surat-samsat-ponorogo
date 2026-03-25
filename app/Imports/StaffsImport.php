<?php

namespace App\Imports;

use App\Models\Staff;
use App\Models\Division;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $division = Division::firstOrCreate(['name' => $row['divisi']]);
        $position = Position::firstOrCreate(['name' => $row['jabatan']]);

        return Staff::updateOrCreate(
            ['nip' => $row['nip']],
            [
                'name' => $row['nama'],
                'phone' => $row['no_hp'],
                'address' => $row['alamat'],
                'division_id' => $division->id,
                'position_id' => $position->id,
            ]
        );
    }
}
