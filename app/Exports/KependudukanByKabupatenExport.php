<?php

namespace App\Exports;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KependudukanByKabupatenExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
  /**
   * Summary of collection
   * @return \Illuminate\Database\Eloquent\Collection<int, Provinsi>
   */
  public function collection()
  {
    return Kabupaten::select('kabupaten.*', 'provinsi.id as id_provinsi', 'provinsi.nama as nama_provinsi')
      ->join('provinsi', 'provinsi.id', '=', 'kabupaten.provinsi_id')
      ->with(relations: ['penduduk'])->withCount('penduduk')->whereNull('kabupaten.deleted_at')->orderBy('provinsi.nama', 'ASC')
      ->orderBy('kabupaten.nama', 'ASC')->get();
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
      $row->nama_provinsi,
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
      'Kabupaten/Kota',
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
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT], 
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ],
      'B1' => [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ],
      'C1' => [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ],
      "A2:C{$lastRow}" => [
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ],
      "C2:C{$lastRow}" => [
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
      ],
    ];
  }
}
