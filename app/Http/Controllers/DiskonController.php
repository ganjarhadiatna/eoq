<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Diskon;

class DiskonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idbarang)
    {
        $diskon = Diskon::orderBy('id', 'desc')
        	->where('idbarang', $idbarang)
        	->paginate(5);
        return view('diskon.index', [
        	'diskon' => $diskon, 
        	'idbarang' => $idbarang
        ]);
    }

    // CRUD
    public function byid($id)
    {
    	return json_encode(Diskon::where('id', $id)->get());
    }

    public function push(Request $req)
    {
    	$this->validate($req, [
            'diskon' => ['required', 'string', 'max:100', 'min:0'],
        ]);

        $diskon = ($req['diskon'] / 100);
        $idbarang = $req['idbarang'];
        $tipe = $req['tipe'];
        $min = $req['min'];
        $max = $req['max'];
        $data = [
            'idbarang' => $idbarang,
            'diskon' => $diskon,
            'tipe' => $tipe,
            'min' => $min,
            'max' => $max
        ];

        // echo json_encode($data);
        if ($tipe == 'unit') 
        {
        	$check = Diskon::CheckTypeDiscount($idbarang, 'unit');
	        if (is_int($check)) 
	        {
	        	return redirect(route('diskon', $idbarang));
	        } 
	        else 
	        {
	        	echo 'kosong';
	        	if (Diskon::Insert($data)) 
		        {
		            return redirect(route('diskon', $idbarang));
		        } 
		        else 
		        {
		            return redirect(route('diskon', $idbarang));
		        }
	        }
        	
        } 
        else 
        {
        	if (Diskon::Insert($data)) 
		    {
		        return redirect(route('diskon', $idbarang));
		    } 
		    else 
		    {
		        return redirect(route('diskon', $idbarang));
		    }
        }

    }

    public function put(Request $req)
    {
    	$this->validate($req, [
            'diskon' => ['required', 'string', 'max:100', 'min:0'],
        ]);

        $diskon = ($req['diskon'] / 100);
        $idbarang = $req['idbarang'];
        $id = $req['id'];
        $min = $req['min'];
        $max = $req['max'];
        $data = [
            'diskon' => $diskon,
            'min' => $min,
            'max' => $max
        ];

        if (Diskon::where('id', $id)->update($data)) 
		{
		    return redirect(route('diskon', $idbarang));
		} 
		else 
		{
		    return redirect(route('diskon', $idbarang));
		}
    }

    public function remove(Request $req)
    {
        $id = $req['id'];
        $idbarang = $req['idbarang'];

        if (Diskon::where('id', $id)->delete())
        {
             return redirect(route('diskon', $idbarang));
        } 
        else 
        {
             return redirect(route('diskon', $idbarang));
        }
    }

}
