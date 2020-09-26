<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    public function index()
    {
        $datas = Card::orderBy('id', 'DESC')->paginate(10);
        return view('setup.card.index', ['datas' => $datas]);
    }


    public function store(Request $request)
    {
        $card = new Card;
        $card->name = $request->name;
        $card->save();
        return response()->json("success");
    }
    
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Card::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }


    public function update(Request $request, Card $card)
    {
        $name = $request->name;
        $card->update(['name' => $name]);
        return response()->json("success");
    }

    public function destroy(Card $card)
    {
        $card->delete();
        return back()
            ->with('success','Card Delete Successfully.');
    }
}
