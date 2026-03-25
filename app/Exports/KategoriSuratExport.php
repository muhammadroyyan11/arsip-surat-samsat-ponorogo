<?php

namespace App\Exports;

use App\Models\KategoriSurat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KategoriSuratExport implements FromCollection, WithHeadings
{
    protected $isTemplate;

    public function __construct($isTemplate = false)
    {
        $this->isTemplate = $isTemplate;
    }

    public function collection()
    {
        if ($this->isTemplate) {
            return collect([]);
        }
        return KategoriSurat::select('name')->get();
    }

    public function headings(): array
    {
        return ['nama_kategori'];
    }
}
