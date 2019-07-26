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

    public function laporanPenjualan(Request $req)
    {
        $tanggal_awal = $req['tanggal_awal'];
        $tanggal_akhir = $req['tanggal_akhir'];
        $sort_by = 'asc';

    	$penjualan = Penjualan::GetAllForLaporan($tanggal_awal, $tanggal_akhir, $sort_by);
    	$pdf = PDF::loadView('laporan.penjualan', compact('penjualan'));
    	return $pdf->download('penjualan.pdf');
    }
}
