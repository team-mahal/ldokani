<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bankentry;

class BankentryController extends Controller
{
    public function index()
    {
        $datas = Bankentry::orderBy('id', 'DESC')->paginate(10);
        return view('setup.bankentry.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $bankentry = new Bankentry;
        $bankentry->name        = $request->name;
        $bankentry->account_no     = $request->account_no;
        $bankentry->account_name       = $request->account_name;
        $bankentry->description     = $request->description;
        $bankentry->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Bankentry::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Bankentry $bankentry)
    {
        $name            = $request->name;
        $description     = $request->description;
        $account_name    = $request->account_name;
        $account_no      = $request->account_no;

        $bankentry->update(['name' => $name, 'description' => $description, 'account_name' => $account_name,'account_no' => $account_no]);
        return response()->json("success");
    }

    public function destroy(Bankentry $bankentry)
    {
        $bankentry->delete();
        return back()
            ->with('success','Bank Entry Delete Successfully.');
    }
}
