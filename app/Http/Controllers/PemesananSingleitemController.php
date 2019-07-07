<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pemesanan;
use App\Pembelian;
Use App\Barang;
Use App\Supplier;
use App\Diskon;

use Auth;

class PemesananSingleitemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function generate_eoq()
    {
        $idbarang = $_GET['idbarang'];
        // $tipe_harga = $_GET['tipe_harga'];
        $idsupplier = $_GET['idsupplier'];

        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Supplier::GetBiayaPemesanan($idsupplier);

        // jumlah permintaan costumer
        if (Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent) > 0) 
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent);
        }
        else
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);
        }

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

        $Q = sqrt((2 * $C * $R) / $H);
        $TC = ($P * $R) + (($C * $R) / $Q) + (($H * $Q) / 2);

        $F = number_format(($R / $Q), 2);

        $B = ($R * $L) / $N;


        // diskon unit
        // satu validasi
        // $diskonUnit = Diskon::GetAllByType($idbarang, 'unit');
        // $dataDiskonUnit = [];
        // foreach ($diskonUnit as $du) {
            
        //     $du_H = ($H - ($H * $du->diskon));
        //     $du_Q = sqrt((2 * $C * $R) / ($du->diskon * $du_H));

        //     $du_P = ($P - ($P * $du->diskon));
        //     $du_TC = (($du_P * $R) + (($C * $R) / $du_Q) + (($du_P * $T * $du_Q) / 2));

        //     $dataDiskonUnit = [
        //         'diskon' => $du->diskon,
        //         'harga_barang' => $du_P,
        //         'jumlah_permintaan' => $R,
        //         'biaya_penyimpanan' => $H,
        //         'biaya_pemesanan' => $C,
        //         'jumlah_unit' => ceil($du_Q),
        //         'total_cost' => ceil($du_TC),
        //         'min' => $du->min,
        //         'max' => $du->max
        //     ];
        // }


        // diskon incremental
        // $diskonIncremental = Diskon::GetAllByType($idbarang, 'incremental');
        // $dataDiskonIncremetal = [];

        // $ds_before = 0;

        // foreach ($diskonIncremental as $key => $di) {
        //     $ui = ($di->min - 1);

        //     if ($key != 0) 
        //     {
        //         $di_before_P = ($P - ($P * $diskonIncremental[$key - 1]->diskon));
        //         $di_current_P = ($P - ($P * $di->diskon));

        //         $pi = $di_before_P - $di_current_P;
        //         $ds = $ds_before + ($ui * $pi);
        //         $ds_before = $ds;
        //     } 
        //     else 
        //     {
        //         $di_before_P = 0;
        //         $di_current_P = ($P - ($P * $di->diskon));

        //         $ds = 0;
        //     }

        //     $di_Q = sqrt(((2 * $R) * ($C + $ds)) / ($di_current_P * $T));
        //     $di_TC = ($di_current_P * $R) + ((($C + $ds) * $R) / $di_Q) + (($di_current_P * $T * $di_Q) / 2) + (($T * $ds) / 2);

        //     $dt = [
        //         'diskon' => $di->diskon,
        //         'harga_barang' => $di_current_P,
        //         'jumlah_permintaan' => $R,
        //         'biaya_penyimpanan' => $H,
        //         'biaya_pemesanan' => $C,
        //         'jumlah_unit' => ceil($di_Q),
        //         'total_cost' => ceil($di_TC),
        //         'min' => $di->min,
        //         'max' => $di->max
        //     ];

        //     array_push($dataDiskonIncremetal, $dt);

        // }

        $data = [
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'biaya_penyimpanan' => $H,
            'biaya_pemesanan' => $C,
            'jumlah_unit' => ceil($Q),
            'total_cost' => ceil($TC),
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B,
            // 'diskon_unit' => $dataDiskonUnit,
            // 'diskon_incremental' => $dataDiskonIncremetal,
        ];
        return json_encode($data);
    }

    public function generate_backorder()
    {
        $idbarang = $_GET['idbarang'];
        $idsupplier = $_GET['idsupplier'];
        $biaya_backorder = $_GET['biaya_backorder'];

        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Supplier::GetBiayaPemesanan($idsupplier);

        // jumlah permintaan costumer
        if (Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent) > 0) 
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent);
        }
        else
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);
        }

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

        $Q = sqrt(((2 * $C * $R) / $H)) * (sqrt(($H + $K) / $K));

        // maximum persediaan
        $J = ($H * $Q) / ($H + $K);
        $M = $Q - $J;


        $TC = ($P * $R) + (($C * $R) / $Q) + (($H * pow(($Q - $J), 2)) / (2 * $Q)) + (($K * pow(($Q - $M),2)) / (2 * $Q));

        $F = number_format(($R / $Q), 2);

        $B = ($R * $L) / $N;

        $data = [
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'biaya_penyimpanan' => $H,
            'biaya_pemesanan' => $C,
            'jumlah_unit' => ceil($Q),
            'total_cost' => ceil($TC),
            'frekuensi_pembelian' => $F,
            'reorder_point' => ceil($B)
        ];

        return json_encode($data);
    }


    // rumus masih error
    public function special_price($idbarang, $price)
    {

        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Supplier::GetBiayaPemesanan($idsupplier);

        // jumlah permintaan costumer
        if (Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent) > 0) 
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent);
        }
        else
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);
        }

        // Harga barang
        $P = Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.3;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu(
        $L = Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);
        
        $d = ($P - $price);
        
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
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'jumlah_unit_sebelumnya' => ceil($Qs),
            'jumlah_unit_khusus' => ceil($Q),
            'total_cost_s' => ceil($TCs),
            'total_cost_n' => ceil($TCn),
            'besar_penghematan' => ceil($gs),
            'besar_penghematan_tc' => ceil($g),
            'frekuensi_pembelian' => $F,
            'reorder_point' => $B
        ];

        return json_encode($data);

    }


    public function increases_price($idbarang, $price)
    {

        // $idbarang = $req['idbarang'];
        // $idsupplier = $req['idsupplier'];
        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idsupplier = Barang::GetIdsupplier($idbarang);

        // total biaya pesanan
        $C = Supplier::GetBiayaPemesanan($idsupplier);

        // jumlah permintaan costumer
        if (Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent) > 0) 
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $monthCurrent);
        }
        else
        {
            $R = Penjualan::GetTotalOrderByMonth($idbarang, $month);
        }

        // Harga barang
        $P = Barang::GetHargaBarang($idbarang);

        // persentase dari harga barang
        $T = 0.3;

        // biaya penyimpanan
        $H = Barang::GetBiayaPenyimpanan($idbarang);

        // lead time per-suplier : per-minggu(
        $L = Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $q = Barang::where('id', $idbarang)->value('stok');
 
        $K = ($price - $P);

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
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
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

        return json_encode($data);

    }

    public function index()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $pemesanan = Pemesanan::GetAllSingleItem(5);
        return view('pesanan.singleitem.index', [
            'barang' => $barang,
            'supplier' => $supplier,
            'pemesanan' => $pemesanan
        ]);
    }
    public function tambah()
    {
        return view('pesanan.singleitem.create');
    }
    public function edit($id)
    {
        $pesanan = Barang::where('id', $id)->get();
        return view('pesanan.singleitem.edit', ['pesanan' => $pesanan]);
    }

    // crud
    public function push(Request $req)
    {
        $this->validate($req, [
            'idbarang' => ['required', 'integer'],
            'jumlah_unit' => ['required', 'integer'],
            'harga_barang' => ['required', 'integer'],
            'frekuensi_pembelian' => ['required'],
            'reorder_point' => ['required']
        ]);

        if ($req['total_cost']) 
        {
            $tc = $req['total_cost'];
        } 
        else 
        {
            $tc = $req['besar_penghematan'];
        }

        if ($tc <= 0) 
        {
            $tcn = 0;
        }
        else
        {
            $tcn = $tc;
        }

        $idusers = Auth::id();
        $data = [
            'idusers' => $idusers,
            'idsupplier' => Barang::where('id', $req['idbarang'])->value('idsupplier'),
            'idbarang' => $req['idbarang'],
            'harga_barang' => $req['harga_barang'],
            'jumlah_unit' => $req['jumlah_unit'],
            'total_cost' => $tcn,
            'frekuensi_pembelian' => $req['frekuensi_pembelian'],
            'reorder_point' => $req['reorder_point'],
            'tipe' => 'singleitem'
        ];

        // echo json_encode($data);

        if (Pemesanan::Insert($data)) 
        {
             return redirect(route('pesanan-item'));
        } 
        else 
        {
             return redirect(route('pesanan-item'));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Pemesanan::where('id', $id)->delete())
        {
             return redirect(route('pesanan-item'));
        } 
        else 
        {
             return redirect(route('pesanan-item'));
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
            return redirect(route('pesanan-item'));
        }

    }

}
