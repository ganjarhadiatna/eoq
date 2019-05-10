<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
Use App\Barang;

use Auth;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        // variable
        $id = 2;

        // total biaya pesanan
        $C = 30000;// Barang::where('id', $id)->value('biaya_pesanan');

        // jumlah permintaan costumer
        $R = 8000;// Penjualan::where('id', $id)->count();

        // Harga barang
        $P = 10000;// Barang::where('id', $id)->value('harga');

        // persentase dari harga barang
        $T = Barang::where('id', $id)->value('diskon');

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

}
