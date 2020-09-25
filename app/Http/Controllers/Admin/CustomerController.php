<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $datas = Customer::orderBy('id', 'DESC')->paginate(10);
        return view('setup.customer.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $customer = new Customer;
        $customer->name        = $request->name;
        $customer->address     = $request->address;
        $customer->email       = $request->email;
        $customer->contact     = $request->contact;
        $customer->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Customer::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Customer $customer)
    {
        $description   = $request->description;
        $name          = $request->name;
        $address       = $request->address;
        $email         = $request->email;
        $contact       = $request->contact;

        $customer->update(['name' => $name, 'address' => $address, 'email' => $email,'contact' => $contact]);
        return response()->json("success");
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()
            ->with('success','Customer Delete Successfully.');
    }
}
