<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemesanan;
use PDF;

class LaporanPemesananController extends Controller
{
    //
    public function index()
    {
        return view('laporan.pemesananindex');
    }

    public function laporanPemesananSingleItem()
    {
        $pemesanan = Pemesanan::GetAllSingleItem(50);
    	$pdf = PDF::loadView('laporan.pemesanansingleitem', compact('pemesanan'));
    	return $pdf->download('pemesanan-single-item.pdf');
    }

    public function laporanPemesananMultiItem()
    {
        $pemesanan = Pemesanan::GetAllMultiItemByIdsupplier(50);
    	$pdf = PDF::loadView('laporan.pemesanansingleitem', compact('pemesanan'));
    	return $pdf->download('pemesanan-single-item.pdf');
    }
}
