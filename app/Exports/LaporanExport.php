<?php

namespace App\Exports;

use App\Models\Penilaian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun, $bulan)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $penilaians = Penilaian::with(['desa', 'klaster', 'indikator'])
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->where('status', 'approved')
            ->get();

        return view('exports.laporan-excel', [
            'penilaians' => $penilaians,
            'tahun' => $this->tahun,
            'bulan' => $this->bulan
        ]);
    }
}
