<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.desa.settings');
    }
}
