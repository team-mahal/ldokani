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
        $company->description = $request->input('description');
        $company->name        = $request->input('name');
        $company->address     = $request->input('address');
        $company->email       = $request->input('email');
        $company->contact     = $request->input('contact');
        $company->save();

        if($request->input('isproduct')){
            echo $company->id;
        }else{
            echo 'success'; 
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

        $description   = $request->input('description');
        $name          = $request->input('name');
        $address       = $request->input('address');
        $email         = $request->input('email');
        $contact       = $request->input('contact');

        $company->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact]);
        echo 'success'; 

    }

    public function destroy(company $company)
    {
        $company->delete();
        return back()
            ->with('success','Company Delete Successfully.');
    }
}
