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
            'Product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        

        if($validation->passes())
        {
            $image = $request->file('Product_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_img'), $new_name);
        }
        else
        {
            $new_name = '';
        }

        $product = new Product;
        $product->product_name      = $request->input('Product_name');
        $product->category_id       = $request->input('Product_category_name');
        $product->company_id        = $request->input('Product_company_name');
        $product->unit_id           = $request->input('Product_unit_name');
        $product->product_barcode   = $request->input('Product_barcode');
        $product->product_model     = $request->input('Product_model');
        $product->product_size      = $request->input('Product_size');
        $product->alarm_level       = $request->input('Product_level');
        $product->warranty          = $request->input('Genral_warranty');
        $product->product_image     = $new_name;
        $product->save();

        echo 'success';  
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Product::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Product $Product)
    {

        $description   = $request->input('description');
        $name          = $request->input('name');
        $address       = $request->input('address');
        $email         = $request->input('email');
        $contact       = $request->input('contact');

        $Product->update(['name' => $name, 'description' => $description, 'address' => $address, 'email' => $email,'contact' => $contact]);
        echo 'success'; 

    }

    public function destroy(Product $Product)
    {
        $Product->delete();
        return back()
            ->with('success','Product Delete Successfully.');
    }
}
