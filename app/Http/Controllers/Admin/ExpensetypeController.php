<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expensetype;

class ExpensetypeController extends Controller
{
    public function index()
    {
        $datas = Expensetype::orderBy('id', 'DESC')->paginate(10);
        return view('setup.expensetype.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $expensetype = new Expensetype;
        $expensetype->name    = $request->name;
        $expensetype->details = $request->details;
        $expensetype->type = $request->type;
        $expensetype->save();
        if($request->isexpense == 1){
            return response()->json($expensetype->id);
        }elseif($request->isincome == 1){
            return response()->json($expensetype->id);
        }else{
            return response()->json("success");
        }
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Expensetype::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Expensetype $expensetype)
    {
        $name = $request->name;
        $details = $request->details;
        $type = $request->type;
        $expensetype->update(['name' => $name, 'details' => $details, 'type' => $type]);
        return response()->json("success");
    }

    public function destroy(Expensetype $expensetype)
    {
        $expensetype->delete();
        return back()
            ->with('success','Expense Type Delete Successfully.');
    }
}
