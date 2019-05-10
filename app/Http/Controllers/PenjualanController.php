<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Penjualan;
use App\Items;

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
        $penjualan = Penjualan::orderBy('id', 'desc')->paginate(5);
        return view('penjualan.index', ['penjualan' => $penjualan]);
    }
    public function tambah()
    {
        $items = Items::orderBy('id', 'desc')->get();
        return view('penjualan.create', [
            'items' => $items,
        ]);
    }
    public function edit($id)
    {
        $penjualan = Penjualan::where('id', $id)->get();
        $items = Items::orderBy('id', 'desc')->get();
        return view('penjualan.edit', [
            'items' => $items,
            'penjualan' => $penjualan
        ]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'iditems' => ['required', 'int'],
            'total_item' => ['required', 'int'],
            'price_item' => ['required', 'int']
        ]);

        $idusers = Auth::id();
        $data = [
            'id' => $idusers,
            'iditems' => $req['iditems'],
            'total_item' => $req['total_item'],
            'price_item' => $req['price_item'],
            'price_total' => ($req['price_item'] * $req['total_item']),
        ];

        // echo json_encode($data);

        if (Penjualan::Insert($data)) 
        {
             return redirect(route('penjualan'));
        } 
        else 
        {
             return redirect(route('penjualan-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'iditems' => ['required', 'int'],
            'total_item' => ['required', 'int'],
            'price_item' => ['required', 'int']
        ]);

        $idusers = Auth::id();
        $id = $req['id'];
        $data = [
            'id' => $idusers,
            'iditems' => $req['iditems'],
            'total_item' => $req['total_item'],
            'price_item' => $req['price_item'],
            'price_total' => ($req['price_item'] * $req['total_item']),
        ];

        if (Penjualan::where('id', $id)->update($data)) 
        {
             return redirect(route('penjualan'));
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

        if (Penjualan::where('id', $id)->delete())
        {
             return redirect(route('penjualan'));
        } 
        else 
        {
             return redirect(route('penjualan'));
        }
    }
}
