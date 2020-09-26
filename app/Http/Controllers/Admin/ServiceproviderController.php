<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Serviceprovider;

class ServiceproviderController extends Controller
{
    public function index()
    {
        $datas = Serviceprovider::orderBy('id', 'DESC')->paginate(10);
        return view('setup.serviceprovider.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $serviceprovider = new Serviceprovider;
        $serviceprovider->description = $request->description;
        $serviceprovider->name        = $request->name;
        $serviceprovider->address     = $request->address;
        $serviceprovider->email       = $request->email;
        $serviceprovider->contact     = $request->contact;
        $serviceprovider->type        = $request->type;
        $serviceprovider->save();

        if($request->isexpense == 1){
            return response()->json($serviceprovider->id);
        }else{
            return response()->json("success");
        }
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Serviceprovider::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Serviceprovider $serviceprovider)
    {

        $description   = $request->description;
        $name          = $request->name;
        $address       = $request->address;
        $email         = $request->email;
        $contact       = $request->contact;
        $type          = $request->type;

        $serviceprovider->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact, 'type' => $type]);
        return response()->json("success");
    }

    public function destroy(Serviceprovider $serviceprovider)
    {
        $serviceprovider->delete();
        return back()
            ->with('success','Service Provider Delete Successfully.');
    }
}
