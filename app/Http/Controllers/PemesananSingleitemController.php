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
        // $idsupplier = $_GET['idsupplier'];

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

        $F = ($R / $Q);

        $B = ($R * $L) / $N;

        $data = [
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'biaya_penyimpanan' => $H,
            'biaya_pemesanan' => $C,
            'jumlah_unit' => ceil($Q),
            'total_cost' => ceil($TC),
            'frekuensi_pembelian' => number_format($F, 2),
            'reorder_point' => number_format($B, 2)
        ];
        return json_encode($data);
    }


    public function generate_discount()
    {
        $idbarang = $_GET['idbarang'];
        // $tipe_harga = $_GET['tipe_harga'];
        // $idsupplier = $_GET['idsupplier'];

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

        $F = ($R / $Q);

        $B = ($R * $L) / $N;

        // diskon incremental
        $diskon = Diskon::GetAllNoLimit($idbarang);
        $dataDiskonUnit = [];
        $counter = 0;

        if (count($diskon) > 0) {
            if (count($diskon) == 1) {
                $counter = count($diskon);

                foreach ($diskon as $du) {
                    $du_H = ($H - ($H * $du->diskon));
                    // $du_Q = sqrt((2 * $C * $R) / ($du->diskon * $du_H));
                    $du_Q = sqrt((2 * $R * $C + $du->diskon) / $H);

                    $du_P = ($P - ($P * $du->diskon));
                    // $du_TC = (($du_P * $R) + (($C * $R) / $du_Q) + (($du_P * $T * $du_Q) / 2));
                    $du_TC = ($R * $P) + ((($C + $du->diskon) * $R) / $du_Q) + (($H * $du_Q) / 2) + (($H * $du->diskon) / 2);

                    $dataDiskonUnit = [
                        'type' => 'unit',
                        'diskon' => $du->diskon,
                        'harga_barang' => number_format($du_P),
                        'jumlah_permintaan' => $R,
                        'biaya_penyimpanan' => $H,
                        'biaya_pemesanan' => $C,
                        'jumlah_unit' => ceil($du_Q),
                        'total_cost' => number_format(ceil($du_TC)),
                        'min' => $du->min,
                        'max' => $du->max,
                        'frekuensi_pembelian' => number_format($F, 2),
                        'reorder_point' => number_format($B, 2)
                    ];
                }

            } else {
                $counter = count($diskon);
                $ds_before = 0;

                foreach ($diskon as $key => $di) {
                    $ui = ($di->min - 1);

                    if ($key != 0) 
                    {
                        $di_before_P = ($P - ($P * $diskon[$key - 1]->diskon));
                        $di_current_P = ($P - ($P * $di->diskon));

                        $pi = $di_before_P - $di_current_P;
                        $ds = $ds_before + ($ui * $pi);
                        $ds_before = $ds;
                    } 
                    else 
                    {
                        $di_before_P = 0;
                        $di_current_P = ($P - ($P * $di->diskon));

                        $ds = 0;
                    }

                    // $di_Q = ((2 * $R) * ($C + $ds)) / ($di_current_P * $T);
                    $di_Q = sqrt(((2 * $R) * ($C + $ds)) / ($di_current_P * $T));
                    $di_TC = ($di_current_P * $R) + ((($C + $ds) * $R) / $di_Q) + (($di_current_P * $T * $di_Q) / 2) + (($T * $ds) / 2);

                    $dt = [
                        'key' => $key,
                        'type' => 'incremental',
                        'diskon' => $di->diskon,
                        'harga_barang' => number_format($di_current_P),
                        'jumlah_permintaan' => $R,
                        'biaya_penyimpanan' => $H,
                        'biaya_pemesanan' => $C,
                        'jumlah_unit' => ceil($di_Q),
                        'total_cost' => number_format(ceil($di_TC)),
                        'min' => $di->min,
                        'max' => $di->max,
                        'frekuensi_pembelian' => number_format($F, 2),
                        'reorder_point' => number_format($B, 2)
                    ];

                    array_push($dataDiskonUnit, $dt);

                }
            }
        }

        else 
        {
            $counter = 0;
            $dataDiskonUnit = [];
        }

        $data = [
            'status' => 'success',
            'counter' => $counter,
            'data' => $dataDiskonUnit
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

        // $Q = sqrt(((2 * $C * $R) / $H) * (($H + $K) / $K));
        $aQ = (2 * $C * $R) / $H;
        $bQ = ($H + $K) / $K;
        $Q = sqrt($aQ * $bQ);

        // maximum persediaan
        $J = ($H * $Q) / ($H + $K);
        $M = $Q - $J;


        $TC = ($P * $R) + (($C * $R) / $Q) + (($H * pow(($Q - $J), 2)) / (2 * $Q)) + (($K * pow(($Q - $M),2)) / (2 * $Q));

        $F = ($R / $Q);

        $B = ($R * $L) / $N;

        $data = [
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'biaya_penyimpanan' => $H,
            'biaya_pemesanan' => $C,
            'jumlah_unit' => ceil($Q),
            'total_cost' => ceil($TC),
            'maximum_persediaan' => ceil($J),
            'frekuensi_pembelian' => number_format($F, 2),
            'reorder_point' => number_format($B, 2)
        ];

        return json_encode($data);
    }


    // rumus masih error
    public function generate_specialprice()
    {
        $idbarang = $_GET['idbarang'];
        $special_price = $_GET['special_price'];
        $tipe_harga = $_GET['tipe_harga'];

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

        // lead time per-suplier : per-minggu(
        $L = Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);
        
        $d = ($P - $special_price);
        
        // EOQ sebelum potongan harga
        $Qs = sqrt((2 * $C * $R) / ($P * $T));
        
        // EOQ pesanan khusus
        $Q = (($d * $R) / (($P - $d) * $T)) + (($P * $Qs) / ($P - $d));

        $jumlah_unit = 0;
        $total_cost = 0;

        if ($tipe_harga == 1) {
            $TCs = (($P - $d) * $Q) + ((($P - $d) * $T * pow($Q, 2)) / (2 * $R)) + $C;

            $jumlah_unit = $Q;
            $total_cost = $TCs;
        } else {
            $TCn = (($P * $Q) - ($d * $Qs)) - (($d * $T * pow($Qs, 2)) / (2 * $R)) + (($P * $T * $Q * $Qs) / (2 * $R)) + (($C * $Q) / $Qs);

            $jumlah_unit = $Qs;
            $total_cost = $TCn;
        }


        $gs = ($C * ($P - $d) / $P) * pow((($Q / $Qs) - 1), 2);

        $F = ($R / $Q);

        $B = (($R * $L) / $N);

        $data = [
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'jumlah_unit' => ceil($jumlah_unit),
            'total_cost' => ceil($total_cost),
            'besar_penghematan' => ceil($gs),
            'biaya_penyimpanan' => $H,
            'frekuensi_pembelian' => number_format($F, 2),
            'reorder_point' => number_format($B, 2),
            'special_price' => $special_price,
            'tipe_harga' => $tipe_harga
        ];

        return json_encode($data);

    }


    public function generate_increaseprice()
    {

        $idbarang = $_GET['idbarang'];
        $increase_price = $_GET['increase_price'];
        $tipe_harga = $_GET['tipe_harga'];

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

        // lead time per-suplier : per-minggu(
        $L = Supplier::GetLeadtime($idsupplier);
        
        // waktu operasional
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $q = Barang::where('id', $idbarang)->value('stok');
 
        $K = ($increase_price - $P);

        // 
        $B = ($R * $L) / $N;

        // EOQ sebelumnya
        // $Q = sqrt((2 * ($C * $R)) / ($P * $T));

        // jumlah unit sebelum kenaikan
        $Qs = sqrt((2 * $C * $R) / ($P * $T));

        // jumlah unit setelah kenaikan
        $Qa = sqrt((2 * $C * $R) / (($P + $K) * $T));

        // jumlah unit pesanan khusus
        $Q = (($K * $R) / ($P * $T)) + ((($P + $K) * $Qa) / $P) - ($q - $B);

        $jumlah_unit = 0;
        $total_cost = 0;

        if ($tipe_harga == 2) {
            // khusus
            $TCs = ($P * $Q) + (($P * $T * $q * $Q) / $R) + (($P * $T * pow($Q, 2)) / (2 * $R)) + (($P * $T * pow($q, 2)) / (2 * $R)) + $C;

            $jumlah_unit = $Q;
            $total_cost = $TCs;
        } else {
            // normal
            $TCn = (($P + $K) * $Q) + ((($P + $K) * $T * $Qa * $Q) / (2 * $R)) + (($P * $T * pow($q, 2)) / (2 * $R));

            $jumlah_unit = $Q;
            $total_cost = $TCn;
        }

        // $gs = $C * (($P / ($P - $K)) * (pow(($Q / $Qa), 2) - 1));
        // $gs = $C * pow((($Qs / $Qa) - 1), 2);
        $gs = $C * (pow(($Qs / $Qa), 2) - 1);
        // $g = $TCn - $TCs;

        $F = ($R / $Qa);

        $habis_barang = ($jumlah_unit / $R) * $N;


        $data = [
            'jumlah_barang_sekarang' => $q,
            'harga_barang' => $P,
            'jumlah_permintaan' => $R,
            'jumlah_unit' => ceil($jumlah_unit),
            'total_cost' => ceil($total_cost),
            'besar_penghematan' => ceil($gs),
            'habis_barang' => ceil($habis_barang),
            'biaya_penyimpanan' => $H,
            'frekuensi_pembelian' => number_format($F, 2),
            'reorder_point' => number_format($B, 2),
            'increase_price' => $increase_price,
            'tipe_harga' => $tipe_harga
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
            'total_cost_multiitem' => 0,
            'frekuensi_pembelian' => $req['frekuensi_pembelian'],
            'reorder_point' => $req['reorder_point'],
            'tipe' => $req['tipe']
        ];


        if (Pemesanan::Insert($data)) 
        {
             // return redirect(route('pesanan-item'));
            return json_encode([
                'status' => 'success',
                'message' => 'Data submited'
            ]);
        } 
        else 
        {
             // return redirect(route('pesanan-item'));
            return json_encode([
                'status' => 'error',
                'message' => 'Failed to submit data'
            ]);
        }
    }

    public function pushAjax(Request $req)
    {
        // $this->validate($req, [
        //     'idbarang' => ['required', 'integer'],
        //     'jumlah_unit' => ['required', 'integer'],
        //     'harga_barang' => ['required', 'integer'],
        //     'frekuensi_pembelian' => ['required'],
        //     'reorder_point' => ['required']
        // ]);

        if ($req['total_cost']) 
        {
            $tc = str_replace(',', '', $req['total_cost']);
        } 
        else 
        {
            $tc = str_replace(',', '', $req['besar_penghematan']);
        }

        if ($tc <= 0) 
        {
            $tcn = 0;
        }
        else
        {
            $tcn = $tc;
        }

        if ($req['jumlah_unit'] < 0) {
            $jumlah_unit = 0;
        } else {
            $jumlah_unit = $req['jumlah_unit'];
        }

        $idusers = Auth::id();
        $data = [
            'idusers' => $idusers,
            'idsupplier' => Barang::where('id', $req['idbarang'])->value('idsupplier'),
            'idbarang' => $req['idbarang'],
            'harga_barang' => str_replace(',', '', $req['harga_barang']),
            'jumlah_unit' => $jumlah_unit,
            'total_cost' => $tcn,
            'total_cost_multiitem' => 0,
            'frekuensi_pembelian' => $req['frekuensi_pembelian'],
            'reorder_point' => $req['reorder_point'],
            'tipe' => $req['tipe']
        ];

        // Pemesanan::Insert($data
        if (Pemesanan::Insert($data))
        {
            $result = [
                'status' => 'success',
                'message' => 'data saved',
                'data' => $data
            ];
        } 
        else 
        {
            $result = [
                'status' => 'error',
                'message' => 'failed to save'
            ];
        }

        return json_encode($result);
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

    function getDataByType($type)
    {
        $pesanan = Pemesanan::GetAllItemByType($type);
        return json_encode($pesanan);
    }

}
