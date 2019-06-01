<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Supplier;
use App\Barang;

use Auth;

class SupplierController extends Controller
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
        $supplier = Supplier::orderBy('id', 'desc')->paginate(5);
        return view('supplier.index', ['supplier' => $supplier]);
    }
    public function tambah()
    {
        return view('supplier.create');
    }
    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->get();
        return view('supplier.edit', ['supplier' => $supplier]);
    }

    // CRUD
    public function byid($id)
    {
        return json_encode(Supplier::where('id', $id)->get());
    }
    public function push(Request $req)
    {
        $this->validate($req, [
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'max:150'],
            'no_telpon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string', 'max:150'],
            'leadtime' => ['required', 'integer', 'max:20'],
            'waktu_operasional' => ['required', 'integer', 'max:20']
        ]);

        $idusers = Auth::id();
        $data = [
            'idusers' => $idusers,
            'nama' => $req['nama'],
            'email' => $req['email'],
            'no_telpon' => $req['no_telpon'],
            'alamat' => $req['alamat'],
            'leadtime' => $req['leadtime'],
            'waktu_operasional' => $req['waktu_operasional']
        ];

        if (Supplier::Insert($data)) 
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'max:150'],
            'no_telpon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string', 'max:150'],
            'leadtime' => ['required', 'integer', 'max:20'],
            'waktu_operasional' => ['required', 'integer', 'max:20']
        ]);

        $idusers = Auth::id();
        $id = $req['id'];
        $data = [
            'idusers' => $idusers,
            'nama' => $req['nama'],
            'email' => $req['email'],
            'no_telpon' => $req['no_telpon'],
            'alamat' => $req['alamat'],
            'leadtime' => $req['leadtime'],
            'waktu_operasional' => $req['waktu_operasional']
        ];

        if (Supplier::where('id', $id)->update($data)) 
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier'));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Supplier::where('id', $id)->delete())
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier'));
        }
    }
}
