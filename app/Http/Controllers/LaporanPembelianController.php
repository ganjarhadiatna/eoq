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

    public function laporanPembelian(Request $req)
    {
        $tanggal_awal = $req['tanggal_awal'];
        $tanggal_akhir = $req['tanggal_akhir'];
        $sort_by = 'asc';

    	$pembelian = Pembelian::GetAllForLaporan($tanggal_awal, $tanggal_akhir, $sort_by);
    	$pdf = PDF::loadView('laporan.pembelian', compact('pembelian'))->setPaper('a4', 'landscape');
    	return $pdf->download('pembelian.pdf');
    }
}
