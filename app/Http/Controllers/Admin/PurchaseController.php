<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchase;
use App\Distributor;
use App\Bankentry;
use App\Card;
use App\Cheque;


class PurchaseController extends Controller
{
    public function index()
    {
        $datas = Purchase::with('distributor')->orderBy('id', 'DESC')->paginate(10);
        $distributor = Distributor::orderBy('id', 'DESC')->select('name','id')->get();
        $bank = Bankentry::orderBy('id', 'DESC')->select('name','id')->get();
        $card = Card::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.purchase.index', ['datas' => $datas, 'distributor' => $distributor, 'bank' => $bank, 'card' => $card]);
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

        $purchase = new Purchase;
        $purchase->distributor_id     = $request->distributor_id;
        $purchase->amount             = $request->amount;
        $purchase->transport_cost     = $request->transport_cost;
        $purchase->discount           = $request->discount;
        $purchase->final_amount       = $request->final_amount;
        $purchase->date               = $request->date1;
        $purchase->payment_amount     = $request->payment_amount;
        $purchase->mode               = $request->mode;
        $purchase->mode_type_id       = $mode_type_id;
        $purchase->total_paid         = $request->final_amount;
        $purchase->save();

        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Purchase::findOrFail($id);
            if($data->mode == 2)
            {
                $cheque = Cheque::findOrFail($data->mode_type_id);
            }else{
                $cheque = '';
            }

            return response()->json(['result' => $data, 'cheque' => $cheque]);
        }
    }


    public function update(Request $request, Purchase $purchase)
    {

        if($request->mode == 2)
        {
            if($purchase->mode == 2){
                $cheque = Cheque::find($purchase->mode_type_id);
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

        $purchase->distributor_id     = $request->distributor_id;
        $purchase->amount             = $request->amount;
        $purchase->transport_cost     = $request->transport_cost;
        $purchase->discount           = $request->discount;
        $purchase->final_amount       = $request->final_amount;
        $purchase->date               = $request->date1;
        $purchase->payment_amount     = $request->payment_amount;
        $purchase->mode               = $request->mode;
        $purchase->mode_type_id       = $mode_type_id;
        
        $purchase->update();
        return response()->json("success");
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return back()
            ->with('success','purchase Delete Successfully.');
    }
}
