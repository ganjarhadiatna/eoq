<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Penjualan;
use App\Pemesanan;
use App\Pembelian;
Use App\Barang;
Use App\Supplier;
use App\Diskon;
use App\Etalase;

use Auth;

class BatasanController extends Controller
{
    // batasan
    public function batasan_modal()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $pemesanan = Pemesanan::GetAllSingleItem(5);
        return view('batasan.modal', [
            'barang' => $barang,
            'supplier' => $supplier,
            'pemesanan' => $pemesanan
        ]);
    }
    public function batasan_gudang()
    {
        $etalase = Etalase::orderBy('id', 'desc')->get();
        return view('batasan.gudang', [
            'etalase' => $etalase
        ]);
    }

    public function batasan_modal_generate(Request $req)
    {
        $kendala_modal = $req['kendala_modal'];

        // $dataString = Barang::GetAllWithoutLimit();
        $data = json_decode(json_encode($_GET['data']));
        $dataString = Barang::GetAllWithID($data);

        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $T = 0.02;

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $dataSave = [];
        $total_investasi = 0;
        $minimum_biaya = 0;

        $beta = 0;
        foreach ($dataString as $key => $bt) {
            if (Penjualan::GetTotalOrderByMonth($bt->idbarang, $monthCurrent) > 0) 
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($bt->idbarang, $monthCurrent);
            }
            else
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($bt->idbarang, $month);
            }

            $ex_q = sqrt((2 * $bt->biaya_pemesanan * $jumlah_permintaan) / $bt->biaya_penyimpanan);

            $F = number_format(($jumlah_permintaan / $ex_q), 2);

            $beta += ($bt->harga_barang * $jumlah_permintaan);
            // $beta += (($bt->biaya_pemesanan * pow(sqrt($bt->harga_barang * $jumlah_permintaan), 2)) / (2 * pow($kendala_modal, 2))) - $F;
        }

        foreach ($dataString as $key => $dt) {
            if (Penjualan::GetTotalOrderByMonth($dt->idbarang, $monthCurrent) > 0) 
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($dt->idbarang, $monthCurrent);
            }
            else
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($dt->idbarang, $month);
            }

            $L = Supplier::GetLeadtime($dt->idsupplier);
            $N = Supplier::GetWaktuOperasional($dt->idsupplier);

            $ex_q = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / $dt->biaya_penyimpanan);
            $ex_a = ($dt->harga_barang * $jumlah_permintaan);
            $ex_b = sqrt(($dt->biaya_penyimpanan * $jumlah_permintaan) / (2 * $dt->biaya_pemesanan));
            $ex_d = (($dt->biaya_penyimpanan * $ex_q) / 2);
            $ex_tc = $ex_a + ($dt->biaya_pemesanan * $ex_b) + $ex_d;
            $a = $a + $ex_a;
            $b = $b + $ex_b;
            $d = $d + $ex_d;
            $Q = $Q + $ex_q;

            $F = number_format(($jumlah_permintaan / $ex_q), 2);
            $B = number_format((($jumlah_permintaan * $L) / $N), 2);

            // feaseble
            $shit = pow(sqrt($beta), 2);
            $ex_beta = (($dt->biaya_pemesanan * $shit) / (2 * pow($kendala_modal, 2))) - $T;
            //(($dt->biaya_pemesanan * pow(sqrt($beta), 2)) / (2 * pow($kendala_modal, 2))) - $F;
            // $ex_beta = (($dt->biaya_pemesanan * pow(sqrt($dt->harga_barang * $jumlah_permintaan), 2)) / (2 * pow($kendala_modal, 2))) - $F;

            $Q_feaseble = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / (($T + $ex_beta) * $dt->harga_barang));

            $E = ($dt->harga_barang * $ex_tc);

            // $Q_feaseble = ($kendala_modal / $E) * $ex_tc;

            // $beta += $ex_beta;
            $total_cost_feasible = (($jumlah_permintaan * $dt->biaya_pemesanan) / $Q_feaseble) + (($Q_feaseble * $dt->harga_barang * $F) / 2);

            // kendala modal
            $kebutuhan_investasi = $dt->harga_barang * ceil($Q_feaseble);

            $total_investasi += $kebutuhan_investasi;
            $minimum_biaya += $total_cost_feasible;

            // save data
            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $dt->idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => number_format($dt->harga_barang),
                'nama_barang' => $dt->nama_barang,
                'jumlah_permintaan' => $jumlah_permintaan,
                'biaya_pemesanan' => number_format($dt->biaya_pemesanan),
                'biaya_penyimpanan' => number_format($dt->biaya_penyimpanan),
                'jumlah_unit' => ceil($ex_q),
                'total_cost' => number_format(ceil($ex_tc)),
                'frekuensi_pembelian' => $F,
                'reorder_point' => ceil($B),
                'tipe' => 'EOQ Sederhana',
                'kebutuhan_investasi' => number_format($kebutuhan_investasi),
                'jumlah_unit_feasible' => ceil($Q_feaseble),
                'total_cost_feasible' => number_format($total_cost_feasible)
            ]);
        }

        // status investasi
        if ($kendala_modal >= $total_investasi)
        {
            $status_investasi = 'Feasible';
        }
        else 
        {
            $status_investasi = 'Tidak Feasible';
        }

        return json_encode([
            'kendala_modal' => number_format($kendala_modal),
            'total_investasi' => number_format(ceil($total_investasi)),
            'minimum_biaya' => number_format(ceil($minimum_biaya)),
            'status_investasi' => $status_investasi,
            'data' => $dataSave
        ]);
    }

    public function batasan_gudang_generate(Request $req)
    {
        $idetalase = $req['idetalase'];

        $dataString = Barang::GetAllByEtalase($idetalase);
        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $dataSave = [];
        $total_luas_gudang = 0;

        // $beta = 0;

        foreach ($dataString as $key => $dt) {
            if (Penjualan::GetTotalOrderByMonth($dt->idbarang, $monthCurrent) > 0) 
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($dt->idbarang, $monthCurrent);
            }
            else
            {
                $jumlah_permintaan = Penjualan::GetTotalOrderByMonth($dt->idbarang, $month);
            }

            $L = Supplier::GetLeadtime($dt->idsupplier);
            $N = Supplier::GetWaktuOperasional($dt->idsupplier);

            $ex_q = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / $dt->biaya_penyimpanan);
            $ex_a = ($dt->harga_barang * $jumlah_permintaan);
            $ex_b = sqrt(($dt->biaya_penyimpanan * $jumlah_permintaan) / (2 * $dt->biaya_pemesanan));
            $ex_d = (($dt->biaya_penyimpanan * $ex_q) / 2);
            $ex_tc = $ex_a + ($dt->biaya_pemesanan * $ex_b) + $ex_d;
            $a = $a + $ex_a;
            $b = $b + $ex_b;
            $d = $d + $ex_d;
            $Q = $Q + $ex_q;

            $F = number_format(($jumlah_permintaan / $ex_q), 2);
            $B = number_format((($jumlah_permintaan * $L) / $N), 2);

            // kendala gudang
            $ex_beta = (($dt->biaya_pemesanan * pow(sqrt(2 * $dt->biaya_pemesanan * $dt->harga_barang), 2)) / pow((2 * $dt->ukuran_barang), 2)) - $F;

            // $QL = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / (($F * $dt->harga_barang) + (2 * $ex_beta * $dt->ukuran_barang)));

            $E = ($dt->ukuran_barang * $Q);

            $QL = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / ($dt->biaya_pemesanan + (2 * $dt->ukuran_etalase) * $dt->ukuran_barang));

            $kebutuhan_gudang = $QL * $dt->ukuran_barang;

            $total_luas_gudang += $QL;

            // save data
            array_push($dataSave, [
                'idusers' => $idusers,
                'idsupplier' => $dt->idsupplier,
                'idbarang' => $dt->idbarang,
                'harga_barang' => number_format($dt->harga_barang),
                'nama_barang' => $dt->nama_barang,
                'etalase' => $dt->etalase,
                'jumlah_permintaan' => $jumlah_permintaan,
                'biaya_pemesanan' => number_format($dt->biaya_pemesanan),
                'biaya_penyimpanan' => number_format($dt->biaya_penyimpanan),
                'jumlah_unit' => ceil($ex_q),
                'total_cost' => number_format(ceil($ex_tc)),
                'frekuensi_pembelian' => $F,
                'reorder_point' => $B,
                'tipe' => 'EOQ Sederhana',
                'ukuran_etalase' => $dt->ukuran_etalase,
                'ukuran_barang' => $dt->ukuran_barang,
                'QL' => ceil($QL),
                'kebutuhan_gudang' => number_format($kebutuhan_gudang, 2)
            ]);
        }

        return json_encode([
            'total_luas_gudang' => number_format($total_luas_gudang, 2),
            'data' => $dataSave
        ]);
    }

    public function save_batasan_modal()
    {
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);

        $dataSave = [];

        foreach ($dataString as $key => $dt) {
            array_push($dataSave, [
                'idusers' => Barang::where('id', $dt->idbarang)->value('idusers'),
                'idsupplier' => Barang::where('id', $dt->idbarang)->value('idsupplier'),
                'idbarang' => $dt->idbarang,
                'harga_barang' => str_replace(',', '', $dt->harga_barang),
                'jumlah_unit' => str_replace(',', '', $dt->jumlah_unit),
                'total_cost' => str_replace(',', '', $dt->total_cost),
                'frekuensi_pembelian' => $dt->frekuensi_pembelian,
                'reorder_point' => $dt->reorder_point,
                'tipe' => 'Batasan Modal'
            ]);
        }

        if (Pemesanan::Insert($dataSave))
        {
            return json_encode([
                'status' => 'success',
                'message' => 'data saved',
                'data' => $dataSave
            ]);
        } 
        else 
        {
            return json_encode([
                'status' => 'error',
                'message' => 'failed to save data'
            ]);
        }
    }

    public function save_batasan_gudang()
    {
        $data = $_GET['data'];
        $dataString = json_decode(json_encode($data), false);

        $dataSave = [];

        foreach ($dataString as $key => $dt) {
            array_push($dataSave, [
                'idusers' => Barang::where('id', $dt->idbarang)->value('idusers'),
                'idsupplier' => Barang::where('id', $dt->idbarang)->value('idsupplier'),
                'idbarang' => $dt->idbarang,
                'harga_barang' => str_replace(',', '', $dt->harga_barang),
                'jumlah_unit' => str_replace(',', '', $dt->jumlah_unit),
                'total_cost' => str_replace(',', '', $dt->total_cost),
                'frekuensi_pembelian' => $dt->frekuensi_pembelian,
                'reorder_point' => $dt->reorder_point,
                'tipe' => 'Batasan Gudang'
            ]);
        }

        if (Pemesanan::Insert($dataSave))
        {
            return json_encode([
                'status' => 'success',
                'message' => 'data saved',
                'data' => $dataSave
            ]);
        } 
        else 
        {
            return json_encode([
                'status' => 'error',
                'message' => 'failed to save data'
            ]);
        }
    }
}
