<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pembelian;
use PDF;

class LaporanPembelianController extends Controller
{
    //
    public function index()
    {
        return view('laporan.pembelianindex');
    }

    public function laporanPembelian()
    {
    	$pembelian = Pembelian::GetAll(50);
    	$pdf = PDF::loadView('laporan.pembelian', compact('pembelian'));
    	return $pdf->download('pembelian.pdf');
    }
}
