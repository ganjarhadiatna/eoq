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

        $dataString = Barang::GetAllWithoutLimit();
        $month = date('m', strtotime('-1 month'));
        $monthCurrent = date('m', strtotime('0 month'));

        $idusers = Auth::id();
        $a = 0;
        $b = 0;
        $d = 0;
        $Q = 0;

        $dataSave = [];
        $total_investasi = 0;
        $minimum_biaya = 0;

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

            // kendala modal
            $kebutuhan_investasi = $Q * $dt->biaya_pemesanan;
            $total_investasi = $total_investasi + $kebutuhan_investasi;

            // feaseble
            $ex_beta = (($dt->biaya_pemesanan * pow(sqrt($dt->harga_barang * $jumlah_permintaan), 2)) / pow((2 * $kendala_modal), 2)) - $F;

            $Q_feaseble = sqrt((2 * $dt->biaya_pemesanan * $jumlah_permintaan) / (($F + $ex_beta) * $dt->harga_barang));

            // $beta += $ex_beta;
            $total_cost_feasible = (($jumlah_permintaan * $dt->biaya_pemesanan) / $Q_feaseble) + (($Q_feaseble * $dt->harga_barang * $F) / 2);

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
                'reorder_point' => $B,
                'tipe' => 'EOQ Sederhana',
                'kebutuhan_investasi' => number_format(ceil($kebutuhan_investasi)),
                'beta' => $ex_beta,
                'jumlah_unit_feasible' => ceil($Q_feaseble),
                'total_cost_feasible' => number_format(ceil($total_cost_feasible))
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
                'QL' => number_format($QL, 2),
                'kebutuhan_gudang' => number_format($kebutuhan_gudang, 2)
            ]);
        }

        return json_encode([
            'total_luas_gudang' => number_format($total_luas_gudang, 2),
            'data' => $dataSave
        ]);
    }
}
