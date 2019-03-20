<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;

use Auth;

class KategoriController extends Controller
{
    // protected $redirectTo = route('kategori');

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
        $category = Category::orderBy('idcategories', 'desc')->paginate(5);
        return view('kategori.index', ['category' => $category]);
    }
    public function tambah()
    {
        return view('kategori.create');
    }
    public function edit($idcategories)
    {
        $category = Category::where('idcategories', $idcategories)->get();
        return view('kategori.edit', ['category' => $category]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'category' => ['required', 'string', 'max:150'],
        ]);

        $id = Auth::id();
        $category = $req['category'];
        $data = [
            'id' => $id,
            'category' => $category
        ];

        if (Category::Insert($data)) 
        {
             return redirect(route('kategori'));
        } 
        else 
        {
             return redirect(route('kategori-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'category' => ['required', 'string', 'max:150'],
        ]);

        $id = Auth::id();
        $idcategories = $req['idcategories'];
        $category = $req['category'];
        $data = [
            'id' => $id,
            'category' => $category
        ];

        if (Category::where('idcategories', $idcategories)->update($data)) 
        {
             return redirect(route('kategori'));
        } 
        else 
        {
             return redirect(route('kategori-edit'));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $idcategories = $req['idcategories'];

        if (Category::where('idcategories', $idcategories)->delete())
        {
             return redirect(route('kategori'));
        } 
        else 
        {
             return redirect(route('kategori'));
        }
    }
}
