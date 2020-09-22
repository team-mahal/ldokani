<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $datas = Company::orderBy('id', 'DESC')->paginate(10);
        return view('setup.company.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $company = new Company;
        $company->description = $request->description;
        $company->name        = $request->name;
        $company->address     = $request->address;
        $company->email       = $request->email;
        $company->contact     = $request->contact;
        $company->save();

        if($request->isproduct == 1){
            return response()->json($company->id);
        }else{
            return response()->json("success");
        }
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Company::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Company $company)
    {
        $description   = $request->description;
        $name          = $request->name;
        $address       = $request->address;
        $email         = $request->email;
        $contact       = $request->contact;

        $company->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact]);
        return response()->json("success");
    }

    public function destroy(company $company)
    {
        $company->delete();
        return back()
            ->with('success','Company Delete Successfully.');
    }
}
