<?php

namespace App\Exports;

use App\Models\AuditLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AuditLogsExport implements FromCollection, WithStrictNullComparison, WithHeadings, WithColumnWidths,WithStyles
{

    protected $audit_logs;

    public function __construct($audit_logs)
    {
        $this->audit_logs = $audit_logs;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->audit_logs;
    }

    public function headings(): array
    {
        return [
            'Identificación Responsable',
            'Nombre Responsable',
            'Email Responsable',
            'Acción',
            'Detalles',
            'Fecha Creación',
            'Fecha Inicio',
            'Fecha Fin',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 23, // 'Identificación Responsable'
            'B' => 20, // 'Nombre Responsable'
            'C' => 23, // 'Email Responsable'
            //'D' => 20, // 'Acción'
            'E' => 28, // 'Detalles'
            'F' => 25, // 'Fecha Creación'
            'G' => 14, // 'Fecha Inicio'
            'H' => 14, // 'Fecha Fin'    
        ];

    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

}
