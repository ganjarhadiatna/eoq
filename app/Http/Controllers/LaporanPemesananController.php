<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pemesanan;
use App\Supplier;
use PDF;

class LaporanPemesananController extends Controller
{
    //
    public function index()
    {
        $supplier = Supplier::Get();
        return view('laporan.pemesananindex', [
            'supplier' => $supplier
        ]);
    }

    public function laporanPemesananSingleItem()
    {
        $pemesanan = Pemesanan::GetAllSingleItem(50);
    	$pdf = PDF::loadView('laporan.pemesanansingleitem', compact('pemesanan'));
    	return $pdf->download('pemesanan-single-item.pdf');
    }

    public function laporanPemesananMultiItem(Request $request)
    {
        $idSupplier = $request['id-supplier'];
        $supplier = Supplier::GetById($idSupplier);
        $pemesanan = Pemesanan::GetAllMultiItemByIdsupplier(50, $supplier);
    	$pdf = PDF::loadView('laporan.pemesananmultiitem', compact('pemesanan'));
    	return $pdf->download('pemesanan-multi-item.pdf');
    }
}
