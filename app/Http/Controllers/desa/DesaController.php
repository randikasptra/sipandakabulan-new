<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Klaster;
use App\Models\IndikatorKlaster;

class DesaController extends Controller
{
    // Dashboard: menampilkan daftar semua klaster
    public function index()
    {
        $klasters = Klaster::withCount('indikators')->get();
        return view('pages.desa.dashboard', compact('klasters'));
    }

    // Menampilkan detail 1 klaster berdasarkan slug
    public function showKlaster($slug)
    {
        $klaster = Klaster::where('slug', $slug)
            ->with('indikators')
            ->firstOrFail();

        return view('pages.desa.klaster-detail', compact('klaster'));
    }

    // Menampilkan detail indikator (opsi nilai + kategori upload)
    public function showIndikator($klasterSlug, $indikatorSlug)
    {
        $indikator = IndikatorKlaster::where('slug', $indikatorSlug)
            ->with(['opsiNilai', 'kategoriUploads'])
            ->firstOrFail();

        return view('pages.desa.indikator-detail', compact('indikator'));
    }
}
