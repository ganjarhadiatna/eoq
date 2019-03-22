<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Transactions;
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
        $transactions = Transactions::orderBy('idtransactions', 'desc')->paginate(5);
        return view('penjualan.index', ['transactions' => $transactions]);
    }
    public function tambah()
    {
        $items = Items::orderBy('iditems', 'desc')->get();
        return view('penjualan.create', [
            'items' => $items,
        ]);
    }
    public function edit($idtransactions)
    {
        $transactions = Transactions::where('idtransactions', $idtransactions)->get();
        $items = Items::orderBy('iditems', 'desc')->get();
        return view('penjualan.edit', [
            'items' => $items,
            'transactions' => $transactions
        ]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'iditems' => ['required', 'int'],
            'count' => ['required', 'int'],
            'price_item' => ['required', 'int']
        ]);

        $id = Auth::id();
        $data = [
            'id' => $id,
            'iditems' => $req['iditems'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_total' => ($req['price_item'] * $req['count']),
        ];

        // echo json_encode($data);

        if (Transactions::Insert($data)) 
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
            'count' => ['required', 'int'],
            'price_item' => ['required', 'int']
        ]);

        $id = Auth::id();
        $idtransactions = $req['idtransactions'];
        $data = [
            'id' => $id,
            'iditems' => $req['iditems'],
            'count' => $req['count'],
            'price_item' => $req['price_item'],
            'price_total' => ($req['price_item'] * $req['count']),
        ];

        if (Transactions::where('idtransactions', $idtransactions)->update($data)) 
        {
             return redirect(route('penjualan'));
        } 
        else 
        {
             return redirect(route('penjualan-edit', $idtransactions));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $idtransactions = $req['idtransactions'];

        if (Transactions::where('idtransactions', $idtransactions)->delete())
        {
             return redirect(route('penjualan'));
        } 
        else 
        {
             return redirect(route('penjualan'));
        }
    }
}
