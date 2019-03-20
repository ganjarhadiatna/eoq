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
        $etalase = Etalase::orderBy('idetalase', 'desc')->paginate(5);
        return view('etalase.index', ['etalase' => $etalase]);
    }
    public function tambah()
    {
        return view('etalase.create');
    }
    public function edit($idetalase)
    {
        $etalase = Etalase::where('idetalase', $idetalase)->get();
        return view('etalase.edit', ['etalase' => $etalase]);
    }

    // CRUD
    public function push(Request $req)
    {
        $this->validate($req, [
            'etalase' => ['required', 'string', 'max:150'],
        ]);

        $id = Auth::id();
        $etalase = $req['etalase'];
        $data = [
            'id' => $id,
            'etalase' => $etalase
        ];

        if (etalase::Insert($data)) 
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase-tambah'));
        }
    }

    public function put(Request $req)
    {
        $this->validate($req, [
            'etalase' => ['required', 'string', 'max:150'],
        ]);

        $id = Auth::id();
        $idetalase = $req['idetalase'];
        $etalase = $req['etalase'];
        $data = [
            'id' => $id,
            'etalase' => $etalase
        ];

        if (Etalase::where('idetalase', $idetalase)->update($data)) 
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase-edit', $idetalase));
        }
    }

    public function remove(Request $req)
    {

        $id = Auth::id();
        $idetalase = $req['idetalase'];

        if (Etalase::where('idetalase', $idetalase)->delete())
        {
             return redirect(route('etalase'));
        } 
        else 
        {
             return redirect(route('etalase'));
        }
    }
}
