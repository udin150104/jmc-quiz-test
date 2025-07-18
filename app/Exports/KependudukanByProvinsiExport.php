<?php

namespace App\Exports;

use App\Models\Provinsi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KependudukanByProvinsiExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
     * Summary of collection
     * @return \Illuminate\Database\Eloquent\Collection<int, Provinsi>
     */
    public function collection()
    {
        return Provinsi::withCount('penduduk')
            ->whereNull('deleted_at')
            ->orderBy('nama', 'ASC')
            ->get();
    }
    /**
     * Summary of map
     * @param mixed $row
     * @return array<mixed|string>
     */
    public function map($row): array
    {
        return [
            $row->nama,
            "{$row->penduduk_count} penduduk",
        ];
    }
    /**
     * Summary of headings
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Provinsi',
            'Jumlah Penduduk',
        ];
    }
    /**
     * Summary of styles
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @return array[]
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        return [
            'A1' => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], // default sebenarnya
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            // Kolom B1 (Header kolom kedua) — rata tengah
            'B1' => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            "A2:B{$lastRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
            "B2:B{$lastRow}" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
