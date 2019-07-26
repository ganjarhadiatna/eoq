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

    public function laporanPemesananSingleItem(Request $req)
    {
        $tanggal_awal = $req['tanggal_awal'];
        $tanggal_akhir = $req['tanggal_akhir'];
        $sort_by = 'asc';

        $pemesanan = Pemesanan::GetAllReportPerItem($tanggal_awal, $tanggal_akhir, $sort_by);
    	$pdf = PDF::loadView('laporan.pemesanansingleitem', compact('pemesanan'))->setPaper('a4', 'landscape');;
    	return $pdf->download('pemesanan-single-item.pdf');
    }

    public function laporanPemesananMultiItem(Request $req)
    {
        $idSupplier = $req['id-supplier'];
        $tanggal_awal = $req['tanggal_awal'];
        $tanggal_akhir = $req['tanggal_akhir'];
        $sort_by = 'asc';

        $pemesanan = Pemesanan::GetAllReportPerItemBySupplier($tanggal_awal, $tanggal_akhir, $sort_by, $idSupplier);
        $pdf = PDF::loadView('laporan.pemesananmultiitem', compact('pemesanan'))->setPaper('a4', 'landscape');;
        return $pdf->download('pemesanan-multi-item.pdf');
    }
}
