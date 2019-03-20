<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Items;
use App\Category;
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
        $items = Items::orderBy('iditems', 'desc')->paginate(5);
        return view('barang.index', ['items' => $items]);
    }
    public function tambah()
    {
        $etalase = Etalase::orderBy('idetalase', 'desc')->get();
        $category = Category::orderBy('idcategories', 'desc')->get();
        return view('barang.create', ['etalase' => $etalase, 'category' => $category]);
    }
    public function edit($iditems)
    {
        $items = Items::where('iditems', $iditems)->get();
        $etalase = Etalase::orderBy('idetalase', 'desc')->get();
        $category = Category::orderBy('idcategories', 'desc')->get();
        return view('barang.edit', ['items' => $items, 'etalase' => $etalase, 'category' => $category]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'title' => ['required', 'string', 'max:150'],
            'stock' => ['required', 'int', 'max:1000'],
            'price' => ['required', 'int', 'max:1000000'],
            'expire_date' => ['required', 'date'],
            'idcategories' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10']
        ]);

        $data = [
            'id' => Auth::id(),
            'idcategories' => $req['idcategories'],
            'idetalase' => $req['idetalase'],
            'title' => $req['title'],
            'stock' => $req['stock'],
            'price' => $req['price'],
            'expire_date' => $req['expire_date']
        ];

        // echo json_encode($data);

        if (Items::Insert($data)) 
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
            'expire_date' => ['required', 'date'],
            'idcategories' => ['required', 'int', 'max:10'],
            'idetalase' => ['required', 'int', 'max:10']
        ]);

        $data = [
            'id' => Auth::id(),
            'idcategories' => $req['idcategories'],
            'idetalase' => $req['idetalase'],
            'title' => $req['title'],
            'stock' => $req['stock'],
            'price' => $req['price'],
            'expire_date' => $req['expire_date']
        ];

        // echo json_encode($data);

        if (Items::where('iditems', $req['iditems'])->update($data)) 
        {
            return redirect(route('barang'));
        } 
        else 
        {
            return redirect(route('barang-edit', $req['iditems']));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $iditems = $req['iditems'];

        if (Items::where('iditems', $iditems)->delete())
        {
             return redirect(route('barang'));
        } 
        else 
        {
             return redirect(route('barang'));
        }
    }
}
