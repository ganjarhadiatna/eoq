<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pembelian;
use App\Pemesanan;
use App\Barang;
use App\Supplier;

use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $penjualan = Penjualan::whereYear('tanggal_penjualan','2019')->get();
        $pembelian = Pembelian::whereYear('tanggal_pembelian','2019')->get();

        $chartPenjualan = $chartPembelian = []; for($i = 0; $i < 12; $i++) { array_push($chartPenjualan, 0); array_push($chartPembelian, 0); }

        foreach($penjualan as $index => $data) {
            $date = DateTime::createFromFormat("Y-m-d",$data->tanggal_penjualan);
            $month = (int) $date->format('m');
            
            $chartPenjualan[$month] = (int) $chartPenjualan[$month] + (int) $data->jumlah_barang;
        }

        foreach($pembelian as $index => $data) {
            $date = DateTime::createFromFormat("Y-m-d",$data->tanggal_pembelian);
            $month = (int) $date->format('m');
            
            $chartPembelian[$month] = (int) $chartPembelian[$month] + (int) $data->jumlah_pembelian;
        }

        $from = date('Y-m-d');
        $to = date('Y-m-d', strtotime("+14 day"));

        $barangKedaluarsa = Barang::whereBetween('tanggal_kadaluarsa',[$from, $to])->get();
        $pemesanan = Pemesanan::all();

        $jumlah_penjualan = Penjualan::GetTotal();
        $jumlah_barang = Barang::GetTotal();
        $jumlah_pesanan = Pemesanan::GetTotal();
        $jumlah_barang_kadaluarsa = Barang::whereBetween('tanggal_kadaluarsa',[$from, $to])->count('id');
        
        return view('home',[
            'chartPembelian' => $chartPembelian,
            'chartPenjualan' => $chartPenjualan,
            'barangKedaluarsa' => $barangKedaluarsa,
            'pemesanan' => $pemesanan,
            'jumlah_penjualan' => $jumlah_penjualan,
            'jumlah_barang' => $jumlah_barang,
            'jumlah_pesanan' => $jumlah_pesanan,
            'jumlah_barang_kadaluarsa' => $jumlah_barang_kadaluarsa
        ]);
    }

    public function profile()
    {
        return view('profile.index');
    }
}
