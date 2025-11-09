<?php

namespace App\Http\Controllers\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KecamatanDashboardController extends Controller
{
    public function index()
    {
        return view('pages.kecamatan.dashboard');
    }
}
