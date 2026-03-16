<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;

class TutorialController extends Controller
{
    public function index()
    {
        return view('pages.desa.tutorial');
    }
}
