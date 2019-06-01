<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Penjualan;
use App\Barang;

use Auth;

class PenjualanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        $penjualan = Penjualan::GetAll(5);
        return view('penjualan.index', [
            'penjualan' => $penjualan,
            'barang' => $barang
        ]);
    }
    public function tambah()
    {
        $barang = Barang::orderBy('id', 'desc')->get();
        return view('penjualan.create', [
            'barang' => $barang,
        ]);
    }
    public function edit($id)
    {
        $penjualan = Penjualan::where('id', $id)->get();
        $barang = Barang::orderBy('id', 'desc')->get();
        return view('penjualan.edit', [
            'barang' => $barang,
            'penjualan' => $penjualan
        ]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'idbarang' => ['required', 'int'],
            'jumlah_barang' => ['required', 'int'],
            'harga_barang' => ['required', 'int']
        ]);

        $idusers = Auth::id();
        $idbarang = $req['idbarang'];
        $data = [
            'idusers' => $idusers,
            'idbarang' => $idbarang,
            'kode_transaksi' => 'BBB-222',
            'jumlah_barang' => $req['jumlah_barang'],
            'harga_barang' => $req['harga_barang'],
            'total_biaya' => ($req['harga_barang'] * $req['jumlah_barang']),
            'satuan' => 'PCS',
            'tanggal_penjualan' => date('Y:m:d')
        ];

        if (Penjualan::insert($data)) 
        {
            $old_stok = Barang::where('id', $idbarang)->value('stok');
            $fresh_stok = $old_stok - $req['jumlah_barang'];
            $stok = [
                'stok' => $fresh_stok
            ];

            if (Barang::where('id', $idbarang)->update($stok)) 
            {
                return redirect(route('penjualan'));
            }
            else
            {
                return redirect(route('penjualan'));
            }
        } 
        else 
        {
             return redirect(route('penjualan'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'idbarang' => ['required', 'int'],
            'jumlah_barang' => ['required', 'int'],
            'harga_barang' => ['required', 'int']
        ]);

        $idusers = Auth::id();
        $idbarang = $req['idbarang'];
        $id = $req['id'];
        $data = [
            'idusers' => $idusers,
            'idbarang' => $idbarang,
            'jumlah_barang' => $req['jumlah_barang'],
            'harga_barang' => $req['harga_barang'],
            'total_biaya' => ($req['harga_barang'] * $req['jumlah_barang']),
        ];

        if (Penjualan::where('id', $id)->update($data)) 
        {
            $old_stok = Barang::where('id', $idbarang)->value('stok');
            $fresh_stok = $old_stok - $req['jumlah_barang'];
            $stok = [
                'stok' => $fresh_stok
            ];

            if (Barang::where('id', $idbarang)->update($stok)) 
            {
                return redirect(route('penjualan'));
            }
            else
            {
                return redirect(route('penjualan'));
            }
        } 
        else 
        {
             return redirect(route('penjualan-edit', $id));
        }
    }

    public function remove(Request $req)
    {
        $idusers = Auth::id();
        $id = $req['id'];
        $idbarang = Penjualan::where('id', $id)->value('idbarang');
        $old_stok = Penjualan::where('id', $id)->value('jumlah_barang');

        $set_stok = Barang::where('id', $idbarang)->value('stok');
        $fresh_stok = $set_stok + $old_stok;
        $stok = [
            'stok' => $fresh_stok
        ];

        if (Barang::where('id', $idbarang)->update($stok))
        {
            if (Penjualan::where('id', $id)->delete()) 
            {
                return redirect(route('penjualan'));
            }
            else
            {
                return redirect(route('penjualan'));
            }
        } 
        else 
        {
            return redirect(route('penjualan'));
        }
    }
}
