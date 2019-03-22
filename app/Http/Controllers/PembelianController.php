<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Buying;
use App\Items;
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
        $buying = Buying::orderBy('idbuying', 'desc')->paginate(5);
        return view('pembelian.index', ['buying' => $buying]);
    }
    public function tambah()
    {
        $items = Items::orderBy('iditems', 'desc')->get();
        $suppliers = Supplier::orderBy('idsuppliers', 'desc')->get();
        return view('pembelian.create', [
            'items' => $items,
            'suppliers' => $suppliers
        ]);
    }
    public function edit($idbuying)
    {
        $buying = Buying::where('idbuying', $idbuying)->get();
        $items = Items::orderBy('iditems', 'desc')->get();
        $suppliers = Supplier::orderBy('idsuppliers', 'desc')->get();
        return view('pembelian.edit', [
            'items' => $items,
            'suppliers' => $suppliers,
            'buying' => $buying
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

        $id = Auth::id();
        $data = [
            'id' => $id,
            'iditems' => $req['iditems'],
            'idsuppliers' => $req['idsuppliers'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_manage' => $req['price_manage'],
            'status' => $req['status'],
        ];

        if (Buying::Insert($data)) 
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

        $id = Auth::id();
        $idbuying = $req['idbuying'];
        $data = [
            'id' => $id,
            'iditems' => $req['iditems'],
            'idsuppliers' => $req['idsuppliers'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_manage' => $req['price_manage'],
            'status' => $req['status'],
        ];

        if (Buying::where('idbuying', $idbuying)->update($data)) 
        {
             return redirect(route('pembelian'));
        } 
        else 
        {
             return redirect(route('pembelian-edit', $idbuying));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $idbuying = $req['idbuying'];

        if (Buying::where('idbuying', $idbuying)->delete())
        {
             return redirect(route('pembelian'));
        } 
        else 
        {
             return redirect(route('pembelian'));
        }
    }
}
