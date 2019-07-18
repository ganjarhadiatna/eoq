<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Pembelian;
use App\Penjualan;
use App\Pemesanan;

class LaporanController extends Controller
{
	public function laporanPemesanan()
    {
		$pemesanan = Pemesanan::GetAllMultiItem(50);
    	$pdf = PDF::loadView('laporan.pemesanan', compact('pemesanan'));
    	return $pdf->download('pemesanan.pdf');
    }

    public function laporanPenjualan()
    {
    	$penjualan = Penjualan::GetAll(50);
    	$pdf = PDF::loadView('laporan.penjualan', compact('penjualan'));
    	return $pdf->download('penjualan.pdf');
    }

    public function laporanPembelian()
    {
		$pembelian = Pembelian::GetAll(50);
    	$pdf = PDF::loadView('laporan.pembelian', compact('pembelian'));
    	return $pdf->download('pembelian.pdf');
    }
}
