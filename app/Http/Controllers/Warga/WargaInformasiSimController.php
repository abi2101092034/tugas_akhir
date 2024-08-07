<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WargaInformasiSimController extends Controller
{
    function index()
    {
        return view('warga.informasi-sim.index');
    }
}
