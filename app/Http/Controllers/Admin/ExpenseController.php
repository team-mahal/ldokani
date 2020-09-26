<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use App\Employee;
use App\Expensetype;
use App\Serviceprovider;
use App\Bankentry;
use App\Card;
use App\Cheque;

class ExpenseController extends Controller
{
    public function index()
    {
        $datas = Expense::with('expense_type')->with('service_provider')->orderBy('id', 'DESC')->paginate(10);
        $expensetype = Expensetype::orderBy('id', 'DESC')->select('name','id')->get();
        $serviceprovider = Serviceprovider::orderBy('id', 'DESC')->select('name','id')->get();
        $employee = Employee::orderBy('id', 'DESC')->select('name','id')->get();
        $bank = Bankentry::orderBy('id', 'DESC')->select('name','id')->get();
        $card = Card::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.expense.index', ['datas' => $datas, 'expensetype' => $expensetype, 'serviceprovider' => $serviceprovider, 'employee' => $employee, 'bank' => $bank, 'card' => $card]);
    }


    public function store(Request $request)
    {

        if($request->mode == 2)
        {
            $cheque = new Cheque;
            $cheque->bank_id     = $request->bank;
            $cheque->cheque_no   = $request->cheque_no;
            $cheque->date        = $request->date;
            $cheque->save();

            $mode_type_id = $cheque->id;
        }else{
            $mode_type_id = $request->card;
        }

        $expense = new Expense;
        $expense->type_id         = $request->type_id;
        $expense->provider_id     = $request->serviceprovider_id;
        $expense->employee_id     = $request->employee_id;
        $expense->amount          = $request->amount;
        $expense->paid_amount     = $request->paid_amount;
        $expense->details         = $request->details;
        $expense->mode            = $request->mode;
        $expense->mode_type_id    = $mode_type_id;
        $expense->save();

        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Expense::findOrFail($id);
            if($data->mode == 2)
            {
                $cheque = Cheque::findOrFail($data->mode_type_id);
            }else{
                $cheque = '';
            }

            return response()->json(['result' => $data, 'cheque' => $cheque]);
        }
    }


    public function update(Request $request, Expense $expense)
    {

        if($request->mode == 2)
        {
            if($expense->mode == 2){
                $cheque = Cheque::find($expense->mode_type_id);
                $cheque->bank_id     = $request->bank;
                $cheque->cheque_no   = $request->cheque_no;
                $cheque->date        = $request->date;
                $cheque->update();
                $mode_type_id = $cheque->id;
            }else{
                $cheque = new Cheque;
                $cheque->bank_id     = $request->bank;
                $cheque->cheque_no   = $request->cheque_no;
                $cheque->date        = $request->date;
                $cheque->save();
                $mode_type_id = $cheque->id;
            }

        }else{
            $mode_type_id = $request->card;
        }

        $expense->type_id         = $request->type_id;
        $expense->provider_id     = $request->serviceprovider_id;
        $expense->employee_id     = $request->employee_id;
        $expense->amount          = $request->amount;
        $expense->paid_amount     = $request->paid_amount;
        $expense->details         = $request->details;
        $expense->mode            = $request->mode;
        $expense->mode_type_id    = $mode_type_id;
        $expense->update();
        return response()->json("success");
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()
            ->with('success','Expense Delete Successfully.');
    }
}
