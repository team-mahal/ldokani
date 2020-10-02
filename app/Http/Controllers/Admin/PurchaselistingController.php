<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Purchaselisting;
use App\Product;
use App\Purchasereceipt;
use App\Category;
use App\Company;
use App\Unit;

class PurchaselistingController extends Controller
{
    public function index()
    {
        $datas = Purchaselisting::with('purchasereceipt')->with('product')->orderBy('id', 'DESC')->paginate(10);
        $category = Category::orderBy('id', 'DESC')->select('name','id')->get();
        $company = Company::orderBy('id', 'DESC')->select('name','id')->get();
        $unit = Unit::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.purchaselisting.index', ['datas' => $datas, 'category' => $category, 'company' => $company, 'unit' => $unit]);
    }


    public function store(Request $request)
    {

        $purchaselisting = new Purchaselisting;
        $purchaselisting->purchasereceipt_id   = $request->purchasereceipt_id;
        $purchaselisting->product_id           = $request->product_id;
        $purchaselisting->quantity             = $request->quantity;
        $purchaselisting->total_buy_price      = $request->total_buy_price;
        $purchaselisting->expire_date          = $request->expire_date;
        $purchaselisting->mrp                  = $request->mrp;
        $purchaselisting->unit_buy_price       = $request->unit_buy_price;
        $purchaselisting->sale_price           = $request->sale_price;
        $purchaselisting->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Purchaselisting::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Purchaselisting $purchaselisting)
    {
        $purchaselisting->purchasereceipt_id   = $request->purchasereceipt_id;
        $purchaselisting->product_id           = $request->product_id;
        $purchaselisting->quantity             = $request->quantity;
        $purchaselisting->total_buy_price      = $request->total_buy_price;
        $purchaselisting->expire_date          = $request->expire_date;
        $purchaselisting->mrp                  = $request->mrp;
        $purchaselisting->unit_buy_price       = $request->unit_buy_price;
        $purchaselisting->sale_price           = $request->sale_price;
        $purchaselisting->update();
        return response()->json("success");
    }

    public function destroy(Purchaselisting $purchaselisting)
    {
        $purchaselisting->delete();
        return back()
            ->with('success','Purchaselisting Delete Successfully.');
    }

    public function getProduct()
    {
        $product = Product::orderBy('id', 'DESC')->select('name','id')->get();
        return response()->json($product);
    }

    public function getPurchasereceipt()
    {
        $distributor = Purchasereceipt::with('distributor')->orderBy('id', 'DESC')->get();
        return response()->json($distributor);
    }
}
