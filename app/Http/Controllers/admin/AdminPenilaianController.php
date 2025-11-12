<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminPenilaianController extends Controller
{
    public function index()
    {
        return view('pages.admin.penilaian.index');
    }
}
