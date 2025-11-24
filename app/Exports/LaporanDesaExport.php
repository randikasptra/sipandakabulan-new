<?php

namespace App\Exports;

use App\Models\Penilaian;
use App\Models\Desa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LaporanDesaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $desaId;
    protected $tahun;
    protected $bulan;
    protected $rowNumber = 0;
    protected $desa;

    public function __construct($desaId, $tahun, $bulan)
    {
        $this->desaId = $desaId;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->desa = Desa::find($desaId);
    }

    /**
     * Ambil data penilaian approved untuk 1 desa
     */
    public function collection()
    {
        return Penilaian::with(['klaster', 'indikator'])
            ->where('desa_id', $this->desaId)
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->where('status', 'approved')
            ->orderBy('klaster_id')
            ->get();
    }

    /**
     * Header kolom
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Desa',
            'Klaster',
            'Indikator',
            'Nilai',
            'Opsi Dipilih',
            'Tanggal Penilaian',
        ];
    }

    /**
     * Mapping data per row
     */
    public function map($penilaian): array
    {
        $this->rowNumber++;

        $opsiDipilih = $penilaian->indikator->opsiNilai->firstWhere('poin', $penilaian->nilai);

        return [
            $this->rowNumber,
            $this->desa->nama_desa ?? '-',
            $penilaian->klaster->title ?? '-',
            $penilaian->indikator->nama_indikator ?? '-',
            $penilaian->nilai ?? 0,
            $opsiDipilih->label ?? '-',
            $penilaian->created_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style header (A1:G1 karena ada 7 kolom)
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'size'  => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style semua data
        $lastRow = $this->rowNumber + 1;

        $sheet->getStyle("A2:G{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center alignment untuk kolom No dan Nilai
        $sheet->getStyle("A2:A{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("E2:E{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Row header height
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    /**
     * Nama sheet
     */
    public function title(): string
    {
        $desaName = $this->desa ? $this->desa->nama_desa : 'Desa';
        return "{$desaName} - {$this->bulan} {$this->tahun}";
    }
}
