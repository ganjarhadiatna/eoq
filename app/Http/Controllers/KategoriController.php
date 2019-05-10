<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Kategori;

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
        $kategori = Kategori::orderBy('id', 'desc')->paginate(5);
        return view('kategori.index', ['kategori' => $kategori]);
    }
    public function tambah()
    {
        return view('kategori.create');
    }
    public function edit($id)
    {
        $kategori = Kategori::where('id', $id)->get();
        return view('kategori.edit', ['kategori' => $kategori]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'kategori' => ['required', 'string', 'max:150'],
        ]);

        $idusers = Auth::id();
        $kategori = $req['kategori'];
        $data = [
            'id' => $idusers,
            'kategori' => $kategori
        ];

        if (Kategori::Insert($data)) 
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
            'kategori' => ['required', 'string', 'max:150'],
        ]);

        $idusers = Auth::id();
        $id = $req['id'];
        $kategori = $req['kategori'];
        $data = [
            'id' => $idusers,
            'kategori' => $kategori
        ];

        if (Kategori::where('id', $id)->update($data)) 
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

        $idusers = Auth::id();
        $id = $req['id'];

        if (Kategori::where('id', $id)->delete())
        {
             return redirect(route('kategori'));
        } 
        else 
        {
             return redirect(route('kategori'));
        }
    }
}
