<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\Category;
use App\Company;
use App\Unit;

class ProductController extends Controller
{
    public function index()
    {
        $datas = Product::with('category')->with('company')->with('unit')->orderBy('id', 'DESC')->paginate(10);
        $category = Category::orderBy('id', 'DESC')->select('name','id')->get();
        $company = Company::orderBy('id', 'DESC')->select('name','id')->get();
        $unit = Unit::orderBy('id', 'DESC')->select('name','id')->get();
        return view('setup.product.index', ['datas' => $datas, 'category' => $category, 'company' => $company, 'unit' => $unit]);
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        

        if($validation->passes() && $request->file('image') != '')
        {
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_img'), $new_name);
        }
        else
        {
            $new_name = '';
        }

        $product = new Product;
        $product->name         = $request->name;
        $product->category_id  = $request->category_name;
        $product->company_id   = $request->company_name;
        $product->unit_id      = $request->unit_name;
        $product->barcode      = $request->barcode;
        $product->model        = $request->model;
        $product->size         = $request->size;
        $product->alarm_level  = $request->level;
        $product->warranty     = $request->genral_warranty;
        $product->image        = $new_name;
        $product->save();

        if($request->ispurchaselisting == 1){
            return response()->json($product->id);
        }else{
            return response()->json("success");
        }

    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Product $product)
    {
        $validation = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        if($validation->passes() && $request->file('image') != '')
        {
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_img'), $new_name);
        }
        else
        {
            $new_name = $product->image;
        }

        $name         = $request->name;
        $category_id  = $request->category_name;
        $company_id   = $request->company_name;
        $unit_id      = $request->unit_name;
        $barcode      = $request->barcode;
        $model        = $request->model;
        $size         = $request->size;
        $alarm_level  = $request->level;
        $warranty     = $request->genral_warranty;
        $image        = $new_name;

        $product->update(['name' => $name, 'category_id' => $category_id, 'company_id' => $company_id, 'unit_id' => $unit_id, 'barcode' => $barcode, 'model' => $model, 'size' => $size, 'alarm_level' => $alarm_level, 'warranty' => $warranty, 'image' => $image]);
        return response()->json("success");
    }

    public function destroy(Product $Product)
    {
        $Product->delete();
        return back()
            ->with('success','Product Delete Successfully.');
    }

    public function last_product()
    {
        $product = Product::latest()->first();
        if(empty($product))
        {
            echo 1;
        }else{
            echo $product->id + 1;
        }
    }
}
