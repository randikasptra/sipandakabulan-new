<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Klaster;

class DesaDashboardController extends Controller
{
    public function index()
    {
        // Ambil user login
        $user = Auth::user();
        $desa = $user->desa ?? null;

        // Ambil semua klaster
        $klasters = Klaster::all();

        // Hitung total EM & total Maksimal
        $totalEm = $klasters->sum('nilai_em');
        $totalMax = $klasters->sum('nilai_maksimal');

        // Hitung progress keseluruhan
        $totalProgress = $totalMax > 0
            ? ($totalEm / $totalMax) * 100
            : 0;

        return view('pages.desa.dashboard', compact(
            'klasters',
            'desa',
            'totalEm',
            'totalMax',
            'totalProgress'
        ));
    }
}
