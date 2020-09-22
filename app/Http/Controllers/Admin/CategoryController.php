<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $datas = Category::orderBy('id', 'DESC')->paginate(10);
        return view('setup.category.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $category = new Category;
        $category->description = $request->description;
        $category->name = $request->name;
        $category->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Category::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Category $category)
    {
        $description = $request->description;
        $name = $request->name;
        $category->update(['name' => $name, 'description' => $description]);
        return response()->json("success"); 
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()
            ->with('success','Category Delete Successfully.');
    }
}
