<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $datas = Employee::orderBy('id', 'DESC')->paginate(10);
        return view('setup.employee.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->name        = $request->name;
        $employee->address     = $request->address;
        $employee->email       = $request->email;
        $employee->contact     = $request->contact;
        $employee->type        = $request->type;
        $employee->balance     = $request->balance;
        $employee->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Employee::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Employee $employee)
    {
        $description   = $request->description;
        $name          = $request->name;
        $address       = $request->address;
        $email         = $request->email;
        $contact       = $request->contact;
        $type         = $request->type;
        $balance       = $request->balance;

        $employee->update(['name' => $name, 'address' => $address, 'email' => $email,'contact' => $contact, 'type' => $type,'balance' => $balance]);
        return response()->json("success");
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()
            ->with('success','Employee Delete Successfully.');
    }
}
