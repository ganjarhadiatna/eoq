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

class PemesananMultiitemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pemesanan = Pemesanan::GetAllMultiItem(5);
        return view('pesanan.index', [
            'pemesanan' => $pemesanan
        ]);

        // $pemesanan = Pemesanan::GetAllMultiItem(5);

        // return json_encode(dump($pemesanan));
    }

    public function multiitem()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        // $pemesanan = Pemesanan::GetAllMultiItem(5);
        return view('pesanan.multiitem.index', [
            'barang' => $barang,
            'supplier' => $supplier
            // 'pemesanan' => $pemesanan
        ]);

        // $pemesanan = Pemesanan::GetAllMultiItem(5);

        // return json_encode(dump($pemesanan));
    }

    public function daftarBarang($idsupplier)
    {
        $supplier = Supplier::where('id', $idsupplier)->get();
        $pemesanan = Pemesanan::GetAllMultiItemByIdsupplier(5, $idsupplier);
        return view('pesanan.multiitem.daftarBarang', [
            'supplier' => $supplier,
            'pemesanan' => $pemesanan
        ]);
    }

    public function tambah()
    {
        return view('pesanan.multiitem.create');
    }

    public function edit($id)
    {
        $pesanan = Barang::where('id', $id)->get();
        return view('pesanan.multiitem.edit', ['pesanan' => $pesanan]);
    }


    // crud
    public function create(Request $req)
    {
        $idsupplier = $req['idsupplier'];

        $fetch = Pemesanan::ByMultiitemSupplier($idsupplier);

        foreach ($fetch as $key => $dt) {
            $data = [
                'kode_transaksi' => 'AAA-111',
                'jumlah_pembelian' => $dt->jumlah_unit,
                'harga_barang' => $dt->harga_barang,
                'biaya_penyimpanan' => $dt->biaya_penyimpanan,
                'diskon' => 0.02, //diskon nanti bisa diganti
                'tanggal_pembelian' => date('Y:m:d H:i:s'),
                'idusers' => Auth::id(),
                'idbarang' => $dt->id_barang,
                'idsupplier' => $dt->idsupplier
            ];
            Pembelian::Insert($data);
        }

        return redirect(route('pembelian'));

        // if (Pembelian::Insert($data)) 
        // {
        //     return redirect(route('pembelian'));
        // } 
        // else 
        // {
        //     return redirect(route('pesanan-multiitem'));
        // }

    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $idsupplier = $req['idsupplier'];

        if (Pemesanan::where('idsupplier', $idsupplier)->delete())
        {
             return redirect(route('pesanan-item'));
        } 
        else 
        {
             return redirect(route('pesanan-item'));
        }
    }


    // eoq
    public function generate_eoq()
    {
        $idsupplier = $_GET['idsupplier'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = Supplier::GetBiayaPemesanan($idsupplier);

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $dataSave = [];

        foreach ($dataString as $key => $dt) {
            $ex_q = sqrt((2 * $biaya_pemesanan * $dt->jumlah_permintaan) / $dt->biaya_penyimpanan);
            $ex_a = ($dt->harga_barang * $dt->jumlah_permintaan);
            $ex_b = sqrt(($dt->biaya_penyimpanan * $dt->jumlah_permintaan) / (2 * $biaya_pemesanan));
            $ex_d = (($dt->biaya_penyimpanan * $ex_q) / 2);
            $ex_tc = $ex_a + ($biaya_pemesanan * $ex_b) + $ex_d;
            $a = $a + $ex_a;
            $b = $b + $ex_b;
            $d = $d + $ex_d;
            $Q = $Q + $ex_q;

            $F = number_format(($dt->jumlah_permintaan / $ex_q), 2);
            $B = ($dt->jumlah_permintaan * $L) / $N;

            // save data
            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => $ex_q,
                'total_cost' => $ex_tc,
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'EOQ Sederhana'
            ]);
        }

        Pemesanan::Insert($dataSave);

        $TC = $a + ($biaya_pemesanan * $b) + $d;

        // update total cost
        foreach ($dataString as $key => $dt) {
            Pemesanan::where('idbarang', $dt->idbarang)
            ->where('tipe', 'EOQ Sederhana')
            ->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => $dataSave
        ]);
    }

    public function generate_bo()
    {
        $idusers = Auth::id();
        $idsupplier = $_GET['idsupplier'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = Supplier::GetBiayaPemesanan($idsupplier);
        $biaya_backorder = $_GET['biaya_backorder'];

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

        // frekuensi permintaan optimum
        $M = 0;

        foreach ($dataString as $key => $dm) {
            $M += ($dm->biaya_penyimpanan * $dm->jumlah_permintaan) / (2 * $biaya_pemesanan);
        }

        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $TC = 0;
        $Q = 0;
        $dataSave = [];
        foreach ($dataString as $key => $dt) {
            // $M = ($dt->biaya_penyimpanan * $dt->jumlah_permintaan) / (2 * $biaya_pemesanan);
            // eoq
            // $Q = ($dt->jumlah_permintaan * $M) * sqrt(($dt->biaya_penyimpanan + $biaya_backorder) / $biaya_backorder);
            $Q = sqrt(((2 * $biaya_pemesanan * $dt->jumlah_permintaan) / $dt->biaya_penyimpanan)) * (sqrt(($dt->biaya_penyimpanan + $biaya_backorder) / $biaya_backorder));

            // maxium
            $J = ($dt->biaya_penyimpanan * $Q) / ($dt->biaya_penyimpanan + $biaya_backorder);
            
            $ex_a = ($dt->harga_barang * $dt->jumlah_permintaan);
            $ex_b = ($dt->jumlah_permintaan / $Q);
            $ex_c = ($dt->biaya_penyimpanan * pow($M, 2)) / (2 * $Q);
            $ex_d = ($biaya_backorder * pow(($Q - $M), 2)) / (2 * $Q);

            // $ex_tc = ($dt->harga_barang * $dt->jumlah_permintaan) + (($biaya_pemesanan * $dt->jumlah_permintaan) / $Q) + (($dt->biaya_penyimpanan * pow(($Q - $J), 2)) / (2 * $Q)) + (($biaya_backorder * pow(($Q - $M),2)) / (2 * $Q));

            $ex_tc = $ex_a + $ex_b + $ex_c + ($ex_d / (2 * $Q));

            // total biaya
            $a += $ex_a;
            $b += $ex_b;
            $c += $ex_c;
            $d += $ex_d;

            $F = number_format(($dt->jumlah_permintaan / $Q), 2);
            $B = ($dt->jumlah_permintaan * $L) / $N;

            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => ceil($Q),
                'total_cost' => ceil($ex_tc),
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'Back Order'
            ]);
        }

        Pemesanan::Insert($dataSave);

        $TC = $a + ($biaya_pemesanan + $b) + $c + $d;

        // update total cost
        foreach ($dataString as $key => $dtc) {
            Pemesanan::where('idbarang', $dtc->idbarang)
            ->where('tipe', 'Back Order')
            ->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => $dataSave
        ]);
    }

    public function generate_sp()
    {
        $idusers = Auth::id();
        $idsupplier = $_GET['idsupplier'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        
        // $biaya_pemesanan = Supplier::GetBiayaPemesanan($idsupplier);

        $special_order = $_GET['special_order'];
        $tipe_harga = $_GET['tipe_harga'];

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

        // total biaya pesanan
        $C = Supplier::GetBiayaPemesanan($idsupplier);

        // persentase dari harga barang
        $T = 0.2;

        $TC = 0;

        $dataSave = [];
        foreach ($dataString as $key => $dt) {

            // jumlah permintaan costumer
            $R = $dt->jumlah_permintaan;

            // Harga barang
            $P = $dt->harga_barang;

            // biaya penyimpanan
            $H = $dt->biaya_penyimpanan;
            
            $d = ($P - $special_order);
            
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

            $F = ceil(($R / $Q));

            $B = ceil(($R * $L) / $N);

            $TC += $total_cost;

            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => ceil($jumlah_unit),
                'total_cost' => ceil($total_cost),
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'Special Order'
            ]);
        }

        Pemesanan::Insert($dataSave);

        foreach ($dataString as $key => $dtc) {
            Pemesanan::where('idbarang', $dtc->idbarang)
            ->where('tipe', 'Special Order')
            ->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => $dataSave
        ]);
    }

    public function generate_bm()
    {
        $idsupplier = $_GET['idsupplier'];
        $kendala_modal = $_GET['kendala_modal'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = Supplier::GetBiayaPemesanan($idsupplier);

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $dataSave = [];

        foreach ($dataString as $key => $dt) {
            $ex_q = sqrt((2 * $biaya_pemesanan * $dt->jumlah_permintaan) / $dt->biaya_penyimpanan);
            $ex_a = ($dt->harga_barang * $dt->jumlah_permintaan);
            $ex_b = sqrt(($dt->biaya_penyimpanan * $dt->jumlah_permintaan) / (2 * $biaya_pemesanan));
            $ex_d = (($dt->biaya_penyimpanan * $ex_q) / 2);
            $ex_tc = $ex_a + ($biaya_pemesanan * $ex_b) + $ex_d;

            $a = $a + $ex_a;
            $b = $b + $ex_b;
            $d = $d + $ex_d;
            $Q = $Q + $ex_q;

            $F = number_format(($dt->jumlah_permintaan / $ex_q), 2);
            $B = ($dt->jumlah_permintaan * $L) / $N;

            // save data
            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => $ex_q,
                'total_cost' => $ex_tc,
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'Batasan Modal'
            ]);
        }

        Pemesanan::Insert($dataSave);

        $TC = $a + ($biaya_pemesanan * $b) + $d;

        // update total cost
        foreach ($dataString as $key => $dt) {
            Pemesanan::where('idbarang', $dt->idbarang)
            ->where('tipe', 'EOQ Sederhana')
            ->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => $dataSave
        ]);
    }

    public function generate_bg()
    {
        $idsupplier = $_GET['idsupplier'];
        $kendala_gudang = $_GET['kendala_gudang'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = Supplier::GetBiayaPemesanan($idsupplier);

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

        $dataSave = [];

        foreach ($dataString as $key => $dt) {
            $ex_q = sqrt((2 * $biaya_pemesanan * $dt->jumlah_permintaan) / $dt->biaya_penyimpanan);
            $ex_a = ($dt->harga_barang * $dt->jumlah_permintaan);
            $ex_b = sqrt(($dt->biaya_penyimpanan * $dt->jumlah_permintaan) / (2 * $biaya_pemesanan));
            $ex_d = (($dt->biaya_penyimpanan * $ex_q) / 2);
            $ex_tc = $ex_a + ($biaya_pemesanan * $ex_b) + $ex_d;
            
            $a = $a + $ex_a;
            $b = $b + $ex_b;
            $d = $d + $ex_d;
            $Q = $Q + $ex_q;

            $F = number_format(($dt->jumlah_permintaan / $ex_q), 2);
            $B = ($dt->jumlah_permintaan * $L) / $N;

            // save data
            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => $ex_q,
                'total_cost' => $ex_tc,
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'Batasan Modal'
            ]);
        }

        Pemesanan::Insert($dataSave);

        $TC = $a + ($biaya_pemesanan * $b) + $d;

        // update total cost
        foreach ($dataString as $key => $dt) {
            Pemesanan::where('idbarang', $dt->idbarang)
            ->where('tipe', 'EOQ Sederhana')
            ->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => $dataSave
        ]);
    }
}
