<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WargaInformasiController extends Controller
{
    function index()
    {
        return view('warga.informasi.index',);
    }
}
