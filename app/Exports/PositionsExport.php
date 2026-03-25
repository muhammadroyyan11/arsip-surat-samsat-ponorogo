<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PositionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Position::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nama Jabatan'];
    }
}
