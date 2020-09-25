<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $datas = Unit::orderBy('id', 'DESC')->paginate(10);
        return view('setup.unit.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $unit = new Unit;
        $unit->name = $request->name;
        $unit->save();
        if($request->isproduct == 1){
            return response()->json($unit->id);
        }else{
            return response()->json("success");
        }
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Unit::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Unit $unit)
    {
        $name = $request->name;
        $unit->update(['name' => $name]);
        return response()->json("success");
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return back()
            ->with('success','Unit Delete Successfully.');
    }
}
