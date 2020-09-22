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

        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request)
    {
        dd($request);
        // echo $request->Product_category_name_edit;

        // $validation = Validator::make($request->all(), [
        //     'Product_image_edit' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        // ]);
        

        // if($validation->passes() && $request->file('Product_image_edit') != '')
        // {
        //     $image = $request->file('Product_image_edit');
        //     $new_name = rand() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('product_img_edit'), $new_name);
        // }
        // else
        // {
        //     $new_name = $product->product_image;
        // }

        // $product_name      = $request->input('Product_name_edit');
        // $category_id       = $request->input('Product_category_name_edit');
        // $company_id        = $request->input('Product_company_name_edit');
        // $unit_id           = $request->input('Product_unit_name_edit');
        // $product_barcode   = $request->input('Product_barcode_edit');
        // $product_model     = $request->input('Product_model_edit');
        // $product_size      = $request->input('Product_size_edit');
        // $alarm_level       = $request->input('Alarm_level_edit');
        // $warranty          = $request->input('Genral_warranty_edit');

        // $product->update(['product_name' => $product_name, 'category_id' => $category_id, 'company_id' => $company_id, 'unit_id' => $unit_id, 'product_barcode' => $product_barcode, 'product_model' => $product_model, 'product_size' => $product_size, 'alarm_level' => $alarm_level, 'warranty' => $warranty, 'product_image' => $new_name]);
        // echo 'success'; 

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
