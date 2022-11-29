<?php

namespace App\Http\Controllers;

use App\Models\CategoryCashOut;
use Illuminate\Http\Request;

class CategoryCashOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoriesOuts = CategoryCashOut::get();
        // dd($categoriesOuts);
        return view('cashout.index', compact('categoriesOuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cashout.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'icon' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'name'  => 'required|unique:category_bussinesses' 
        ]); 
 
        //upload image
        $image = $request->file('icon');
        $image->storeAs('public/category_cash_outs', $image->hashName());
 
        // dd($request->name, $request->file('image'));
        //save to DB
        $category = CategoryCashOut::create([
            'icon'  => $image->hashName(),
            'name'   => $request->name,
        ]);
 
        if($category){
             //redirect dengan pesan sukses
             return redirect()->route('cashout.index');
         }else{
             //redirect dengan pesan error
             return redirect()->route('cashout.index');
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
