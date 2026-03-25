<?php

namespace App\Exports;

use App\Models\KategoriSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriSuratExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return KategoriSurat::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Kategori'];
    }
}
