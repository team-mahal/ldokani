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
        $distributor->description = $request->input('description');
        $distributor->name        = $request->input('name');
        $distributor->address     = $request->input('address');
        $distributor->email       = $request->input('email');
        $distributor->contact     = $request->input('contact');
        $distributor->balance     = $request->input('balance');
        $distributor->save();

        echo 'success';  
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

        $description   = $request->input('description');
        $name          = $request->input('name');
        $address       = $request->input('address');
        $email         = $request->input('email');
        $contact       = $request->input('contact');
        $balance       = $request->input('balance');

        $distributor->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact, 'balance' => $balance]);
        echo 'success'; 

    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return back()
            ->with('success','Distributor Delete Successfully.');
    }
}
