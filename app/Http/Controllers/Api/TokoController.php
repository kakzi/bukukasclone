<?php

namespace App\Http\Controllers\Api;

use App\Models\TokoStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TokoController extends Controller
{
    public function create(Request $request)
    {
        //set validasi
        $customer_id = auth()->user();
        $validator = Validator::make($request->all(), [
            'category_id'      => 'required',
            'name'      => 'required',
            'address'      => 'required',
            'phone'     => 'required|unique:toko_stores',
            'type'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //create customer
        $category_id = TokoStore::create([
            'category_id'      => $request->category_id,
            'customer_id'     => $customer_id->id,
            'name'     => $request->name,
            'address'     => $request->address,
            'phone'  => $request->phone,
            'type'  => $request->type
        ]);

        $toko = TokoStore::where('id',  $category_id->id)->first();
        //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Toko berhasil dibuat!',
            'data'    => $toko
        ], 201);
    }
}
