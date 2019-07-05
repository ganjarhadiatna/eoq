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
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $pemesanan = Pemesanan::GetAllMultiItem(5);
        return view('pesanan.multiitem.index', [
            'barang' => $barang,
            'supplier' => $supplier,
            'pemesanan' => $pemesanan
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
        $id = $req['id'];

        if (Pemesanan::where('id', $id)->delete())
        {
             return redirect(route('pesanan-multiitem'));
        } 
        else 
        {
             return redirect(route('pesanan-multiitem'));
        }
    }


    // eoq
    public function generate_eoq()
    {
        $idsupplier = $_GET['idsupplier'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = $_GET['biaya_pemesanan'];

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $L = Supplier::GetLeadtime($idsupplier);
        $N = Supplier::GetWaktuOperasional($idsupplier);

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
            $dataSave = [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => $ex_q,
                'total_cost' => $ex_tc,
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'multiitem'
            ];
            Pemesanan::Insert($dataSave);
        }

        $TC = $a + ($biaya_pemesanan * $b) + $d;

        // update total cost
        foreach ($dataString as $key => $dt) {
            Pemesanan::where('idbarang', $dt->idbarang)->where('tipe', 'multiitem')->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => ''
        ]);
    }

    public function generate_bo()
    {
        $idusers = Auth::id();
        $idsupplier = $_GET['idsupplier'];
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);
        $biaya_pemesanan = $_GET['biaya_pemesanan'];
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
        $dataS = [];
        foreach ($dataString as $key => $dt) {
            // eoq
            $Q = ($dt->jumlah_permintaan * $M) * sqrt(($dt->biaya_penyimpanan + $biaya_backorder) / $biaya_backorder);

            // maxium
            $J = ($dt->biaya_penyimpanan * $Q) / ($dt->biaya_penyimpanan + $biaya_backorder);
            
            $ex_a = ($dt->harga_barang * $dt->jumlah_permintaan);
            $ex_b = ($dt->jumlah_permintaan / $Q);
            $ex_c = ($dt->biaya_penyimpanan * pow($M, 2)) / (2 * $Q);
            $ex_d = ($biaya_backorder * pow(($Q - $M), 2)) / (2 * $Q);
            $ex_tc = ($dt->harga_barang * $dt->jumlah_permintaan) + (($biaya_pemesanan * $dt->harga_barang) / $Q) + (($dt->biaya_penyimpanan * pow(($Q - $J), 2)) / (2 * $Q)) + (($biaya_backorder * pow(($Q - $M),2)) / (2 * $Q));

            // total biaya
            $a += $ex_a;
            $b += $ex_b;
            $c += $ex_c;
            $d += $ex_d;

            $F = number_format(($dt->jumlah_permintaan / $Q), 2);
            $B = ($dt->jumlah_permintaan * $L) / $N;

            $dataSave = [
                'idusers' => $idusers,
                'idsupplier' => $idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => $dt->harga_barang,
                'jumlah_unit' => ceil($Q),
                'total_cost' => ceil($ex_tc),
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'multiitem'
            ];
            Pemesanan::Insert($dataSave);
        }

        $TC = $a + ($biaya_pemesanan * $b) + $c + $d;

        // update total cost
        foreach ($dataString as $key => $dtc) {
            Pemesanan::where('idbarang', $dtc->idbarang)->where('tipe', 'multiitem')->Update(['total_cost_multiitem' => $TC]);
        }

        return json_encode([
            'status' => 'success',
            'message' => ''
        ]);
    }
}
