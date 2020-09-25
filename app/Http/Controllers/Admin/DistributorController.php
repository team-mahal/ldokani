<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Distributor;

class DistributorController extends Controller
{
    public function index()
    {
        $datas = Distributor::orderBy('id', 'DESC')->paginate(10);
        return view('setup.distributor.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $distributor = new Distributor;
        $distributor->description = $request->description;
        $distributor->name        = $request->name;
        $distributor->address     = $request->address;
        $distributor->email       = $request->email;
        $distributor->contact     = $request->contact;
        $distributor->balance     = $request->balance;
        $distributor->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Distributor::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Distributor $distributor)
    {

        $description   = $request->description;
        $name          = $request->name;
        $address       = $request->address;
        $email         = $request->email;
        $contact       = $request->contact;
        $balance       = $request->balance;

        $distributor->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact, 'balance' => $balance]);
        return response()->json("success");
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return back()
            ->with('success','Distributor Delete Successfully.');
    }
}
