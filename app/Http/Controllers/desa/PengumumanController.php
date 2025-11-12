<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;

class PengumumanController extends Controller
{
    public function index()
    {
        return view('pages.desa.pengumuman');
    }
}
