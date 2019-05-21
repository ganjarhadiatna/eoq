<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pemesanan;
Use App\Barang;
Use App\Supplier;

use Auth;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function eoq() {

        // variable
        $id = 2;

        // total biaya pesanan
        $C = 30000;// Barang::where('id', $id)->value('biaya_pesanan');

        // jumlah permintaan costumer
        $R = 8000;// Penjualan::where('id', $id)->count();

        // Harga barang
        $P = 10000;// Barang::where('id', $id)->value('harga');

        // persentase dari harga barang
        $T = 0.02;

        // biaya penyimpanan
        $H = 3000;// Barang::where('id', $id)->value('biaya_penyimpanan');

        // lead time per-suplier : per-minggu
        $L = 2;

        // waktu operasional
        $N = 50;

        // jumlah pesanan optimum
        $Q = number_format(sqrt(((2 * $C * $R) / $H)), 0);

        $TC = ($P * $R) + ($H * $Q);

        $F = $R / $Q;

        $B = ($R * $L) / $N;

        echo "<h1>EOQ Sederhana: </h1>";
        echo "Total biaya pesanan: " . $C . "<br>";
        echo "Jumlah permintaan costumer: " . $R . "<br>";
        echo "Harga barang: " . $P . "<br>";
        echo "Persentase barang: " . $T . "<br>";
        echo "Biaya penyimpanan: " . $H . "<br>";
        echo "<br>";
        echo "Jumlah unit: " . $Q;
        echo "<br><br>";
        echo "Total cost persediaan: " . $TC;
        echo "<br><br>";
        echo "Frekuensi pembelian per-tahun: " . $F;
        echo "<br><br>";
        echo "Re-order point: " . $B;
    }

    public function generate_eoq($idbarang)
    {
        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $idsupplier = Barang::where('id', $idbarang)->value('idsupplier');

        // total biaya pesanan
        $C = Barang::where('id', $idbarang)->value('biaya_pemesanan');

        // jumlah permintaan costumer
        $R = 100;// Penjualan::where('id', $id)->count();

        // Harga barang
        $P = Barang::where('id', $idbarang)->value('harga_barang');

        // persentase dari harga barang
        $T = 0.02;

        // biaya penyimpanan
        $H = Barang::where('id', $idbarang)->value('biaya_penyimpanan');

        // lead time per-suplier : per-minggu
        $L = Supplier::where('id', $idsupplier)->value('leadtime');

        // waktu operasional
        $N = 10;

        $Q = number_format(sqrt(((2 * $C * $R) / $H)), 0);

        $TC = ($P * $R) + ($H * $Q);

        $F = number_format(($R / $Q), 2);

        $B = ($R * $L) / $N;

        $data = [
            'jumlah_unit' => $Q,
            'total_cost' => $TC,
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];

        return json_encode($data);
    }

    public function index()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $pemesanan = Pemesanan::orderBy('id', 'desc')->paginate(5);
        return view('pesanan.index', [
            'barang' => $barang,
            'supplier' => $supplier,
            'pemesanan' => $pemesanan
        ]);
    }
    public function tambah()
    {
        return view('pesanan.create');
    }
    public function edit($id)
    {
        $pesanan = Barang::where('id', $id)->get();
        return view('pesanan.edit', ['pesanan' => $pesanan]);
    }

    // crud
    public function push(Request $req)
    {
        $this->validate($req, [
            'idbarang' => ['required', 'integer'],
            'jumlah_unit' => ['required', 'integer'],
            'total_cost' => ['required', 'integer'],
            'frekuensi_pembelian' => ['required'],
            'reorder_point' => ['required', 'integer']
        ]);

        $idusers = Auth::id();
        $data = [
            'idusers' => $idusers,
            'idbarang' => $req['idbarang'],
            'jumlah_unit' => $req['jumlah_unit'],
            'total_cost' => $req['total_cost'],
            'frekuensi_pembelian' => $req['frekuensi_pembelian'],
            'reorder_point' => $req['reorder_point']
        ];

        // echo json_encode($data);

        if (Pemesanan::Insert($data)) 
        {
             return redirect(route('pesanan'));
        } 
        else 
        {
             return redirect(route('pesanan'));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Pemesanan::where('id', $id)->delete())
        {
             return redirect(route('pesanan'));
        } 
        else 
        {
             return redirect(route('pesanan'));
        }
    }

}
