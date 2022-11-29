<?php

namespace App\Http\Controllers;

use App\Models\MetodePayment as ModelsMetodePayment;
use Illuminate\Http\Request;

class MetodePayment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metodePayments = ModelsMetodePayment::get();
        // dd($metodePayments);
        return view('metodepayment.index', compact('metodePayments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('metodepayment.create');
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
            'name'  => 'required|unique:metode_payments' 
        ]); 
 
        //upload image
        $image = $request->file('icon');
        $image->storeAs('public/metode_payments', $image->hashName());
 
        // dd($request->name, $request->file('image'));
        //save to DB
        $metode_payment = ModelsMetodePayment::create([
            'icon'  => $image->hashName(),
            'name'   => $request->name,
        ]);
 
        if($metode_payment){
             //redirect dengan pesan sukses
             return redirect()->route('metode_payment.index');
         }else{
             //redirect dengan pesan error
             return redirect()->route('metode_payment.index');
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
