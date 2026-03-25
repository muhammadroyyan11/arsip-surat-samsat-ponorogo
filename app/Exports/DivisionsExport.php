<?php

namespace App\Exports;

use App\Models\Division;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DivisionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Division::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Divisi'];
    }
}
