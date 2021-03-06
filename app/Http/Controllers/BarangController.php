<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Barang;
use App\Kategori;
use App\Etalase;
use App\Supplier;

use Auth;

class BarangController extends Controller
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
        $etalase = Etalase::orderBy('id', 'desc')->get();
        $kategori = Kategori::orderBy('id', 'desc')->get();
        $supplier = Supplier::orderBy('id', 'desc')->get();
        $barang = Barang::GetAll(5);
        return view('barang.index', [
            'barang' => $barang, 
            'etalase' => $etalase, 
            'kategori' => $kategori,
            'supplier' => $supplier
        ]);
    }
    public function tambah()
    {
        $etalase = Etalase::orderBy('id', 'desc')->get();
        $kategori = Kategori::orderBy('id', 'desc')->get();
        return view('barang.create', ['etalase' => $etalase, 'kategori' => $kategori]);
    }
    public function edit($id)
    {
        $barang = Barang::where('id', $id)->get();
        $etalase = Etalase::orderBy('id', 'desc')->get();
        $kategori = Kategori::orderBy('id', 'desc')->get();
        return view('barang.edit', ['barang' => $barang, 'etalase' => $etalase, 'kategori' => $kategori]);
    }

    // CRUD
    public function all()
    {
        return json_encode(Barang::get());
    }
    public function byid($id)
    {
        return json_encode(Barang::where('id', $id)->get());
    }
    public function bysupplier($idsupplier)
    {
        return json_encode(Barang::GetAllBySupplier($idsupplier));
    }
    public function price_item($id)
    {
        $harga_barang = Barang::where('id', $id)->value('harga_jual');
        $stok_barang = Barang::where('id', $id)->value('stok');
        return json_encode([
            'id' => $id, 
            'harga_barang' => $harga_barang,
            'stok_barang' => $stok_barang
        ]);
    }
    public function push(Request $req)
    {
        $this->validate($req, [
            'nama_barang' => ['required', 'string', 'max:150'],
            'satuan_barang' => ['required', 'string', 'max:150'],
            'ukuran_barang' => ['required', 'min:0'],
            'stok' => ['required', 'int', 'max:1000'],
            'stok_pengaman' => ['required', 'int', 'max:1000'],
            'harga_barang' => ['required', 'int', 'max:1000000'],
            'harga_jual' => ['required', 'int', 'max:1000000'],
            'biaya_penyimpanan' => ['required', 'int', 'max:1000000'],
            'tanggal_kadaluarsa' => ['required', 'date'],
            'idkategori' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10'],
            'idsupplier' => ['required', 'int', 'max:10']
        ]);

        // $temp = $req['harga_barang'] * 0.02;

        $data = [
            'idusers' => Auth::id(),
            'idkategori' => $req['idkategori'],
            'idetalase' => $req['idetalase'],
            'idsupplier' => $req['idsupplier'],
            'nama_barang' => $req['nama_barang'],
            'satuan_barang' => $req['satuan_barang'],
            'ukuran_barang' => $req['ukuran_barang'],
            'stok' => $req['stok'],
            'stok_pengaman' => $req['stok_pengaman'],
            'harga_barang' => $req['harga_barang'],
            'harga_jual' => $req['harga_jual'],
            'biaya_penyimpanan' => $req['biaya_penyimpanan'],
            'tanggal_kadaluarsa' => $req['tanggal_kadaluarsa']
        ];

        // echo json_encode($data);

        if (Barang::Insert($data)) 
        {
             return redirect(route('barang'));
        } 
        else 
        {
             return redirect(route('barang'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'nama_barang' => ['required', 'string', 'max:150'],
            'satuan_barang' => ['required', 'string', 'max:150'],
            'ukuran_barang' => ['required', 'min:0'],
            'stok' => ['required', 'int', 'max:1000'],
            'stok_pengaman' => ['required', 'int', 'max:1000'],
            'harga_barang' => ['required', 'int', 'max:1000000'],
            'harga_jual' => ['required', 'int', 'max:1000000'],
            'biaya_penyimpanan' => ['required', 'int', 'max:1000000'],
            'tanggal_kadaluarsa' => ['required', 'date'],
            'idkategori' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10'],
            'idsupplier' => ['required', 'int', 'max:10']
        ]);

        $data = [
            'idusers' => Auth::id(),
            'idkategori' => $req['idkategori'],
            'idetalase' => $req['idetalase'],
            'idsupplier' => $req['idsupplier'],
            'nama_barang' => $req['nama_barang'],
            'satuan_barang' => $req['satuan_barang'],
            'ukuran_barang' => $req['ukuran_barang'],
            'stok' => $req['stok'],
            'stok_pengaman' => $req['stok_pengaman'],
            'harga_barang' => $req['harga_barang'],
            'harga_jual' => $req['harga_jual'],
            'biaya_penyimpanan' => $req['biaya_penyimpanan'],
            'tanggal_kadaluarsa' => $req['tanggal_kadaluarsa']
        ];

        // echo json_encode($data);

        if (Barang::where('id', $req['id'])->update($data)) 
        {
            return redirect(route('barang'));
        } 
        else 
        {
            return redirect(route('barang', $req['id']));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Barang::where('id', $id)->delete())
        {
             return redirect(route('barang'));
        } 
        else 
        {
             return redirect(route('barang'));
        }
    }
}
