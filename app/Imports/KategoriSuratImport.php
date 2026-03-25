<?php

namespace App\Imports;

use App\Models\KategoriSurat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriSuratImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return KategoriSurat::updateOrCreate(
            ['name' => $row['nama_kategori']]
        );
    }
}
