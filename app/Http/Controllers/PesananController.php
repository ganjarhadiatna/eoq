<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transactions;
Use App\Items;

use Auth;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        // variable
        $idbarang = 2;

        // total biaya pesanan
        $C = Items::where('iditems', $idbarang)->value('price_order');

        // jumlah permintaan costumer
        $R = Transactions::where('iditems', $idbarang)->count();

        // Harga barang
        $P = Items::where('iditems', $idbarang)->value('price');

        // persentase dari harga barang
        $T = Items::where('iditems', $idbarang)->value('discount');

        // biaya penyimpanan
        $H = Items::where('iditems', $idbarang)->value('price_store');

        // jumlah pesanan optimum
        $Q = number_format(sqrt(((2 * $C * $R) / ($P * $T))), 2);

        // unit
        $CR = $C * $R;
        $HQ = $H * $Q;
        $Qq = $Q * 2;
        $TC = number_format(($R * $P) + ($CR / 2) + ($HQ / 2), 2);

        echo "<h1>EOQ Sederhana: </h1>";
        echo "Total biaya pesanan: " . $C . "<br>";
        echo "Jumlah permintaan costumer: " . $R . "<br>";
        echo "Harga barang: " . $P . "<br>";
        echo "Persentase barang: " . $T . "<br>";
        echo "Biaya penyimpanan: " . $H . "<br>";
        echo "<br>";
        echo "Jumlah pesanan optimum: " . $Q;
        echo "<br><br>";
        echo "Jumlah unit: " . $TC;
    }

}
