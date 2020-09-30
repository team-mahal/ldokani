<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchasereceipt;
use App\Distributor;
use App\Bankentry;
use App\Card;
use App\Cheque;


class PurchasereceiptController extends Controller
{
    public function index()
    {
        $datas = Purchasereceipt::with('distributor')->orderBy('id', 'DESC')->paginate(10);
        $distributor = Distributor::orderBy('id', 'DESC')->select('name','id')->get();
        $bank = Bankentry::orderBy('id', 'DESC')->select('name','id')->get();
        $card = Card::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.purchasereceipt.index', ['datas' => $datas, 'distributor' => $distributor, 'bank' => $bank, 'card' => $card]);
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

        $purchasereceipt = new Purchasereceipt;
        $purchasereceipt->distributor_id     = $request->distributor_id;
        $purchasereceipt->amount             = $request->amount;
        $purchasereceipt->transport_cost     = $request->transport_cost;
        $purchasereceipt->discount           = $request->discount;
        $purchasereceipt->final_amount       = $request->final_amount;
        $purchasereceipt->date               = $request->date1;
        $purchasereceipt->payment_amount     = $request->payment_amount;
        $purchasereceipt->mode               = $request->mode;
        $purchasereceipt->mode_type_id       = $mode_type_id;
        $purchasereceipt->total_paid         = $request->final_amount;
        $purchasereceipt->save();

        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Purchasereceipt::findOrFail($id);
            if($data->mode == 2)
            {
                $cheque = Cheque::findOrFail($data->mode_type_id);
            }else{
                $cheque = '';
            }

            return response()->json(['result' => $data, 'cheque' => $cheque]);
        }
    }


    public function update(Request $request, Purchasereceipt $purchasereceipt)
    {

        if($request->mode == 2)
        {
            if($purchasereceipt->mode == 2){
                $cheque = Cheque::find($purchasereceipt->mode_type_id);
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

        $purchasereceipt->distributor_id     = $request->distributor_id;
        $purchasereceipt->amount             = $request->amount;
        $purchasereceipt->transport_cost     = $request->transport_cost;
        $purchasereceipt->discount           = $request->discount;
        $purchasereceipt->final_amount       = $request->final_amount;
        $purchasereceipt->date               = $request->date1;
        $purchasereceipt->payment_amount     = $request->payment_amount;
        $purchasereceipt->mode               = $request->mode;
        $purchasereceipt->mode_type_id       = $mode_type_id;
        
        $purchasereceipt->update();
        return response()->json("success");
    }

    public function destroy(Purchasereceipt $purchasereceipt)
    {
        $purchasereceipt->delete();
        return back()
            ->with('success','purchasereceipt Delete Successfully.');
    }
}
