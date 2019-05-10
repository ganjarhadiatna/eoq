<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Barang;
use App\Kategori;
use App\Etalase;

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
        $barang = Barang::orderBy('id', 'desc')->paginate(5);
        return view('barang.index', ['barang' => $barang, 'etalase' => $etalase, 'kategori' => $kategori]);
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
    public function price_item($id)
    {
        $price = Barang::where('id', $id)->value('price');
        return json_encode([
            'id' => $id, 
            'price' => $price
        ]);
    }
    public function push(Request $req)
    {
        $this->validate($req, [
            'title' => ['required', 'string', 'max:150'],
            'stock' => ['required', 'int', 'max:1000'],
            'price' => ['required', 'int', 'max:1000000'],
            'discount' => ['int', 'min:0', 'max:100'],
            'price_order' => ['required', 'int', 'max:1000000'],
            'price_store' => ['required', 'int', 'max:1000000'],
            'expire_date' => ['required', 'date'],
            'idkategori' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10']
        ]);

        $data = [
            'id' => Auth::id(),
            'idkategori' => $req['idkategori'],
            'idetalase' => $req['idetalase'],
            'title' => $req['title'],
            'stock' => $req['stock'],
            'price' => $req['price'],
            'discount' => $req['discount'],
            'price_order' => $req['price_order'],
            'price_store' => $req['price_store'],
            'expire_date' => $req['expire_date']
        ];

        // echo json_encode($data);

        if (Barang::Insert($data)) 
        {
             return redirect(route('barang'));
        } 
        else 
        {
             return redirect(route('barang-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'title' => ['required', 'string', 'max:150'],
            'stock' => ['required', 'int', 'max:1000'],
            'price' => ['required', 'int', 'max:1000000'],
            'discount' => ['int', 'min:0', 'max:100'],
            'price_order' => ['required', 'int', 'max:1000000'],
            'price_store' => ['required', 'int', 'max:1000000'],
            'expire_date' => ['required', 'date'],
            'idkategori' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10']
        ]);

        $data = [
            'id' => Auth::id(),
            'idkategori' => $req['idkategori'],
            'idetalase' => $req['idetalase'],
            'title' => $req['title'],
            'stock' => $req['stock'],
            'price' => $req['price'],
            'discount' => ($req['discount'] / 100),
            'price_order' => $req['price_order'],
            'price_store' => $req['price_store'],
            'expire_date' => $req['expire_date']
        ];

        // echo json_encode($data);

        if (Barang::where('id', $req['id'])->update($data)) 
        {
            return redirect(route('barang'));
        } 
        else 
        {
            return redirect(route('barang-edit', $req['id']));
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
