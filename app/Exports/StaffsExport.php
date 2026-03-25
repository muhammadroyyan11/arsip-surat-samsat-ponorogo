<?php

namespace App\Exports;

use App\Models\Staff;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StaffsExport implements FromCollection, WithHeadings, WithMapping
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
        return Staff::with(['division', 'position'])->get();
    }

    public function map($staff): array
    {
        return [
            $staff->nip,
            $staff->name,
            $staff->phone,
            $staff->address,
            $staff->division ? $staff->division->name : '',
            $staff->position ? $staff->position->name : '',
        ];
    }

    public function headings(): array
    {
        return ['nip', 'nama', 'no_hp', 'alamat', 'divisi', 'jabatan'];
    }
}
