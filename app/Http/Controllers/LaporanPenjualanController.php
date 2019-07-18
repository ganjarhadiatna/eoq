<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use PDF;

class LaporanPenjualanController extends Controller
{
    //
    public function index()
    {
        return view('laporan.penjualanindex');
    }

    public function laporanPenjualan()
    {
    	$penjualan = Penjualan::GetAll(50);
    	$pdf = PDF::loadView('laporan.penjualan', compact('penjualan'));
    	return $pdf->download('penjualan.pdf');
    }
}
