<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BarangMasukExport implements FromArray, WithHeadings, WithEvents, ShouldAutoSize
{
    protected $reqs;
    protected $data = [];
    protected $mergeGroups = [];

    public function __construct($reqs)
    {
        $this->reqs = $reqs;
        $this->generateData();
    }

    protected function generateData()
    {
        $request = $this->reqs;

        $barangMasukList = BarangMasuk::with(['items', 'user'])->latest();

        if ($request->filled('filter-kategori')) {
            $barangMasukList->where('kategori_id', $request->input('filter-kategori'));
        }
        if ($request->filled('filter-sub-kategori')) {
            $barangMasukList->where('sub_kategori_id', $request->input('filter-sub-kategori'));
        }
        if ($request->filled('filter-tahun')) {
            $barangMasukList->whereYear('created_at', $request->input('filter-tahun'));
        }
        if ($request->filled('search')) {
            $barangMasukList->where('suplier', 'like', '%' . $request->input('search') . '%');
        }

        $barangMasukList = $barangMasukList->get();

        $no = 1;
        $rowIndex = 2;

        foreach ($barangMasukList as $bm) {
            $startRow = $rowIndex;
            $first = true;

            foreach ($bm->items as $k => $item) {
                $this->data[] = [
                    $first ? $no : '',
                    $first ? $bm->created_at->format('d/m/Y H:i:s') : '',
                    $first ? $bm->suplier : '',
                    $first ? optional($bm->user)->name : '',
                    $first ? 'Gudang Utama' : '',
                    'ATK' . str_pad($k + 1, 4, '0', STR_PAD_LEFT),
                    $item->nama,
                    'Rp. ' . number_format($item->price, 0, ',', '.'),
                    $item->qty . ' ' . $item->satuan,
                    'Rp. ' . number_format($item->qty * $item->price, 0, ',', '.'),
                    $item->status >0 ? "Sudah di verisikasi" : "Belum di verifikasi",
                ];

                $first = false;
                $rowIndex++;
            }

            $endRow = $rowIndex - 1;
            if ($endRow > $startRow) {
                $this->mergeGroups[] = [$startRow, $endRow];
            }

            $no++;
        }
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Asal Barang',
            'Penerima',
            'Unit',
            'Kode',
            'Nama Barang',
            'Harga',
            'Jumlah',
            'Total',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Merge kolom tertentu
                foreach ($this->mergeGroups as [$start, $end]) {
                    foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
                        $cellRange = "{$col}{$start}:{$col}{$end}";
                        $sheet->mergeCells($cellRange);
                        $sheet->getStyle($cellRange)->getAlignment()->setVertical('center');
                        $sheet->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                    }
                }

                // Border dan rata tengah semua isi
                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
                    ->getAlignment()
                    ->setHorizontal('center')
                    ->setVertical('center');

                // Bold dan background heading
                $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFDCE6F1'],
                    ],
                ]);
            },
        ];
    }
}
