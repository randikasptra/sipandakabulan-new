<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesaDashboardController extends Controller
{
    public function index()
    {
        return view('pages.desa.dashboard');
    }
}
