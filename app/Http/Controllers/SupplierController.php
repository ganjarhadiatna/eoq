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
        $supplier = Supplier::orderBy('od', 'desc')->paginate(5);
        return view('supplier.index', ['supplier' => $supplier]);
    }
    public function tambah()
    {
        return view('supplier.create');
    }
    public function edit($od)
    {
        $supplier = Supplier::where('od', $od)->get();
        return view('supplier.edit', ['supplier' => $supplier]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'max:150'],
            'phone_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:150']
        ]);

        $idusers = Auth::id();
        $data = [
            'id' => $idusers,
            'name' => $req['name'],
            'email' => $req['email'],
            'phone_number' => $req['phone_number'],
            'address' => $req['address']
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
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'max:150'],
            'phone_number' => ['required', 'string', 'max:15'],
            'address' => ['required', 'string', 'max:150']
        ]);

        $idusers = Auth::id();
        $od = $req['od'];
        $data = [
            'id' => $idusers,
            'name' => $req['name'],
            'email' => $req['email'],
            'phone_number' => $req['phone_number'],
            'address' => $req['address']
        ];

        if (Supplier::where('od', $od)->update($data)) 
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier-edit', $od));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $od = $req['od'];

        if (Supplier::where('od', $od)->delete())
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier'));
        }
    }
}
