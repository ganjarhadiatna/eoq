<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pemesanan;
use App\Pembelian;
Use App\Barang;
Use App\Supplier;

use Auth;

class PemesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generate_eoq($idbarang)
    {
        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];

        $month = date('m', strtotime('-1 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Barang::GetBiayaPemesanan($idbarang);

        // jumlah permintaan costumer
        $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);

        // Harga barang
        $P = Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.02;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu
        $L = Supplier::GetLeadtime($idsupplier);

        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $Q = ceil(sqrt((2 * $C * $R) / $H));

        $TC = ($P * $R) + ($H * $Q);

        $F = number_format(($R / $Q), 2);

        $B = ceil(($R * $L) / $N);

        $data = [
            'jumlah_unit' => $Q,
            'total_cost' => $TC,
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];
        return json_encode($data);
    }

    public function generate_backorder($idbarang, $biaya_backorder)
    {
        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $month = date('m', strtotime('-1 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Barang::GetBiayaPemesanan($idbarang);

        // jumlah permintaan costumer
        $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);

        // Harga barang
        $P = Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.02;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu
        $L = Supplier::GetLeadtime($idsupplier);

        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);

        // biaya back order
        $K = $biaya_backorder;

        $Q = ceil(sqrt(((2 * $C * $R) / $H)) * (sqrt(($H + $K) / $K)));

        // maximum persediaan
        $J = ($H * $Q) / ($H + $K);
        $M = $Q - $J;


        $TC = ceil(($P * $R) + (($C * $R) / $Q) + (($H * pow(($Q - $J), 2)) / (2 * $Q)) + (($K * pow(($Q - $M),2)) / (2 * $Q)));

        $F = number_format(($R / $Q), 2);

        $B = ceil(($R * $L) / $N);

        $data = [
            'jumlah_unit' => $Q,
            'total_cost' => $TC,
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];

        return json_encode($data);
    }


    // rumus masih error
    public function special_price($idbarang, $price)
    {

        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $month = date('m', strtotime('-1 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = 30000;//Barang::GetBiayaPemesanan($idbarang);

        // jumlah permintaan costumer
        $R = 8000;//Penjualan::GetTotalOrderByMonth($idbarang, $month);

        // Harga barang
        $P = 10000;//Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.3;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu(
        $L = 2;//Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = 50;//Supplier::GetWaktuOperasional($idsupplier);
        
        $d = 1000; //($P - $price);
        
        // EOQ sebelum potongan harga
        $Qs = sqrt((2 * $C * $R) / ($P * $T));
        
        // EOQ pesanan khusus
        $Q = (($d * $R) / (($P - $d) * $T)) + (($P * $Qs) / ($P - $d));
        
        $TCs = (($P - $d) * $Q) + ((($P - $d) * $T * pow($Q, 2)) / (2 * $R)) + $C;
        $TCn = (($P * $Q) - ($d * $Qs)) - (($d * $T * pow($Qs, 2)) / (2 * $R)) + (($P * $T * $Q * $Qs) / (2 * $R)) + (($C * $Q) / $Qs);

        $gs = ($C * ($P - $d) / $P) * pow((($Q / $Qs) - 1), 2);
        $g = $TCn - $TCs;

        $F = number_format(($R / $Q), 2);

        $B = ceil(($R * $L) / $N);

        $data = [
            'jumlah_unit_sebelumnya' => ceil($Qs),
            'jumlah_unit_khusus' => ceil($Q),
            'total_cost_s' => ceil($TCs),
            'total_cost_n' => ceil($TCn),
            'besar_penghematan' => ceil($gs),
            'besar_penghematan_tc' => ceil($g),
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];

        return json_encode(dump($data));

    }


    public function increases_price($idbarang, $price)
    {

        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $month = date('m', strtotime('-1 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = 30000;//Barang::GetBiayaPemesanan($idbarang);

        // jumlah permintaan costumer
        $R = 8000;//Penjualan::GetTotalOrderByMonth($idbarang, $month);

        // Harga barang
        $P = 10000;//Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.3;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu(
        $L = 2;//Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = 50;//Supplier::GetWaktuOperasional($idsupplier);

        $q = 346;//Barang::where('id', $idbarang)->value('stok');
 
        $K = 1000;//($price - $P);

        // 
        $B = ($R * $L) / $N;

        // EOQ sebelumnya
        // $Q = sqrt((2 * ($C * $R)) / ($P * $T));

        // jumlah unit sebelum kenaikan
        $Qs = sqrt((2 * $C * $R) / ($P * $T));

        // jumlah unit setelah kenaikan
        $Qa = sqrt((2 * $C * $R) / (($P + $K) * $T));

        // jumlah unit pesanan khusus
        $Q = (($K * $R) / ($P * $T)) + ((($P + $K) * $Qa) / $R) - $q;

        $TCs = ($P * $Q) + (($P * $T * $q * $Q) / $R) + (($P * $T * pow($Q, 2)) / (2 * $R)) + (($P * $T * pow($q, 2)) / (2 * $R)) + $C;

        $TCn = (($P + $K) * $Q) + ((($P + $K) * $T * $Qa * $Q) / (2 * $R)) + (($P * $T * pow($q, 2)) / (2 * $R));

        // $gs = $C * (($P / ($P - $K)) * (pow(($Q / $Qa), 2) - 1));
        $gs = (($K + ((($P + $K) * $T * $Qa) / $R) - (($P * $T * $q) / $R)) * $Q) - (($P * $T * pow($Q, 2)) / (2 * $R)) - $C;
        // $gs = ($C * ($P + $K) / $P) * pow((($Q / $Qa) - 1), 2);
        $g = $TCn - $TCs;

        $F = number_format(($R / $Qa), 2);


        $data = [
            // 'Jumlah_unit_awal' => $Q,
            'jumlah_unit_sebelumnya' => ceil($Qs),
            'jumlah_unit_kenaikan' => ceil($Qa),
            'jumlah_unit_khusus' => ceil($Q),
            'total_cost_s' => ceil($TCs),
            'total_cost_n' => ceil($TCn),
            'besar_penghematan' => ceil($gs),
            'besar_penghematan_tc' => ceil($g),
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];

        return json_encode(dump($data));

    }

    public function index()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $pemesanan = Pemesanan::GetAll(5);
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
            'reorder_point' => ['required']
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

    public function create(Request $req)
    {
        $id = $req['id'];

        $fetch = json_decode(Pemesanan::ByID($id), true);

        $data = [
            'kode_transaksi' => 'AAA-111',
            'jumlah_pembelian' => $fetch[0]['jumlah_unit'],
            'harga_barang' => $fetch[0]['harga_barang'],
            'biaya_penyimpanan' => $fetch[0]['biaya_penyimpanan'],
            'diskon' => 0.02, //diskon nanti bisa diganti
            'tanggal_pembelian' => date('Y:m:d H:i:s'),
            'idusers' => Auth::id(),
            'idbarang' => $fetch[0]['id_barang'],
            'idsupplier' => $fetch[0]['idsupplier']
        ];

        if (Pembelian::Insert($data)) 
        {
            return redirect(route('pembelian'));
        } 
        else 
        {
            return redirect(route('pesanan'));
        }

    }

}
