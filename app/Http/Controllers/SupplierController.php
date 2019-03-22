<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Supplier;
use App\Items;

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
        $supplier = Supplier::orderBy('idsuppliers', 'desc')->paginate(5);
        return view('supplier.index', ['supplier' => $supplier]);
    }
    public function tambah()
    {
        return view('supplier.create');
    }
    public function edit($idsuppliers)
    {
        $supplier = Supplier::where('idsuppliers', $idsuppliers)->get();
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

        $id = Auth::id();
        $data = [
            'id' => $id,
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

        $id = Auth::id();
        $idsuppliers = $req['idsuppliers'];
        $data = [
            'id' => $id,
            'name' => $req['name'],
            'email' => $req['email'],
            'phone_number' => $req['phone_number'],
            'address' => $req['address']
        ];

        if (Supplier::where('idsuppliers', $idsuppliers)->update($data)) 
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier-edit', $idsuppliers));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $idsuppliers = $req['idsuppliers'];

        if (Supplier::where('idsuppliers', $idsuppliers)->delete())
        {
             return redirect(route('supplier'));
        } 
        else 
        {
             return redirect(route('supplier'));
        }
    }
}
