<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Pembelian;
use App\Barang;
use App\Supplier;

use Auth;

class PembelianController extends Controller
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
        $pembelian = Pembelian::orderBy('id', 'desc')->paginate(5);
        return view('pembelian.index', ['pembelian' => $pembelian]);
    }
    public function tambah()
    {
        $items = Barang::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('pembelian.create', [
            'items' => $items,
            'suppliers' => $suppliers
        ]);
    }
    public function edit($id)
    {
        $pembelian = Pembelian::where('id', $id)->get();
        $items = Barang::orderBy('id', 'desc')->get();
        $suppliers = Supplier::orderBy('id', 'desc')->get();
        return view('pembelian.edit', [
            'items' => $items,
            'suppliers' => $suppliers,
            'pembelian' => $pembelian
        ]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'iditems' => ['required', 'int', 'max:50'],
            'idsuppliers' => ['required', 'int', 'max:50'],
            'status' => ['required', 'string', 'max:20'],
            'count' => ['required', 'int',],
            'price_item' => ['required', 'int',],
            'price_manage' => ['required', 'int',],
        ]);

        $idusers = Auth::id();
        $data = [
            'id' => $idusers,
            'iditems' => $req['iditems'],
            'idsuppliers' => $req['idsuppliers'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_manage' => $req['price_manage'],
            'status' => $req['status'],
        ];

        if (Pembelian::Insert($data)) 
        {
             return redirect(route('pembelian'));
        } 
        else 
        {
             return redirect(route('pembelian-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'iditems' => ['required', 'int', 'max:50'],
            'idsuppliers' => ['required', 'int', 'max:50'],
            'status' => ['required', 'string', 'max:20'],
            'count' => ['required', 'int',],
            'price_item' => ['required', 'int',],
            'price_manage' => ['required', 'int',],
        ]);

        $idusers = Auth::id();
        $id = $req['id'];
        $data = [
            'id' => $idusers,
            'iditems' => $req['iditems'],
            'idsuppliers' => $req['idsuppliers'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_manage' => $req['price_manage'],
            'status' => $req['status'],
        ];

        if (Pembelian::where('id', $id)->update($data)) 
        {
             return redirect(route('pembelian'));
        } 
        else 
        {
             return redirect(route('pembelian-edit', $id));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Pembelian::where('id', $id)->delete())
        {
             return redirect(route('pembelian'));
        } 
        else 
        {
             return redirect(route('pembelian'));
        }
    }
}
