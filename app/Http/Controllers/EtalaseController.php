<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Etalase;

use Auth;

class EtalaseController extends Controller
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
        $etalase = Etalase::orderBy('id', 'desc')->paginate(5);
        return view('etalase.index', ['etalase' => $etalase]);
    }
    public function tambah()
    {
        return view('etalase.create');
    }
    public function edit($id)
    {
        $etalase = Etalase::where('id', $id)->get();
        return view('etalase.edit', ['etalase' => $etalase]);
    }

    // CRUD
    public function byid($id)
    {
        return json_encode(Etalase::where('id', $id)->get());
    }
    public function push(Request $req)
    {
        $this->validate($req, [
            'etalase' => ['required', 'string', 'max:150'],
        ]);

        $idusers = Auth::id();
        $etalase = $req['etalase'];
        $data = [
            'idusers' => $idusers,
            'etalase' => $etalase
        ];

        if (etalase::Insert($data)) 
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'etalase' => ['required', 'string', 'max:150'],
        ]);

        $idusers = Auth::id();
        $id = $req['id'];
        $etalase = $req['etalase'];
        $data = [
            'idusers' => $idusers,
            'etalase' => $etalase
        ];

        if (Etalase::where('id', $id)->update($data)) 
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase', $id));
        }
    }

    public function remove(Request $req)
    {

        $idusers = Auth::id();
        $id = $req['id'];

        if (Etalase::where('id', $id)->delete())
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase'));
        }
    }
}
