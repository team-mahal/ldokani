<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Income;
use App\Expensetype;
use App\Serviceprovider;
use App\Bankentry;
use App\Card;
use App\Cheque;

class IncomeController extends Controller
{
    public function index()
    {
        $datas = Income::with('expense_type')->with('service_provider')->orderBy('id', 'DESC')->paginate(10);
        $expensetype = Expensetype::orderBy('id', 'DESC')->where('type', 2)->select('name','id')->get();
        $serviceprovider = Serviceprovider::orderBy('id', 'DESC')->select('name','id')->get();
        $bank = Bankentry::orderBy('id', 'DESC')->select('name','id')->get();
        $card = Card::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.income.index', ['datas' => $datas, 'expensetype' => $expensetype, 'serviceprovider' => $serviceprovider, 'bank' => $bank, 'card' => $card]);
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

        $income = new Income;
        $income->type_id         = $request->type_id;
        $income->provider_id     = $request->serviceprovider_id;
        $income->amount          = $request->amount;
        $income->paid_amount     = $request->paid_amount;
        $income->details         = $request->details;
        $income->mode            = $request->mode;
        $income->mode_type_id    = $mode_type_id;
        $income->save();

        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Income::findOrFail($id);
            if($data->mode == 2)
            {
                $cheque = Cheque::findOrFail($data->mode_type_id);
            }else{
                $cheque = '';
            }

            return response()->json(['result' => $data, 'cheque' => $cheque]);
        }
    }


    public function update(Request $request, Income $income)
    {

        if($request->mode == 2)
        {
            if($income->mode == 2){
                $cheque = Cheque::find($income->mode_type_id);
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

        $income->type_id         = $request->type_id;
        $income->provider_id     = $request->serviceprovider_id;
        $income->amount          = $request->amount;
        $income->paid_amount     = $request->paid_amount;
        $income->details         = $request->details;
        $income->mode            = $request->mode;
        $income->mode_type_id    = $mode_type_id;
        $income->update();
        return response()->json("success");
    }

    public function destroy(Income $income)
    {
        $income->delete();
        return back()
            ->with('success','Income Delete Successfully.');
    }
}
