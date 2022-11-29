<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\HistoryStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $id = $request->id;

        $product = Product::where('toko_store_id', $id)->get();
        if($product == null){
            return response()->json([
                'success' => false,
                'message' => 'Toko anda belum memiliki produk!'
            ], 400);
        } 
        return response()->json([
            'success' => true,
            'message' => 'Get Data product Berhasil',
            'data' => $product
        ], 200);
    }

    public function store_product(Request $request)
    {
        // dd(substr($request->name,0,3));
       
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'name'      => 'required',
            'harga_jual'      => 'required',
            'stock'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $code = substr($request->name,0,3);
        // dd(strtoupper($code));
         //create customer
        $product = Product::create([
            'toko_store_id' => $request->toko_store_id,
            'name'     => $request->name,
            'code'     => strtoupper($code)."-". rand(100,999),
            'harga_jual'     => $request->harga_jual,
            'is_hpp'     => $request->is_hpp,
            'hpp'     => $request->hpp,
            'is_notif_stock'     => $request->is_notif_stock,
            'stock'     => $request->stock,
            'stock_minimum'     => 1,
            'date'     => now(),
        ]);
         //Add History Stock Out when any Tansaction of product
        $history = [
            'toko_store_id' => $request->toko_store_id,
            'product_id' => $product->id,
            'type' => "in",
            'quantity'     => $request->quantity,
            'catatan'     => "Persedian Awal",
            'stock_progress'  => $request->quantity,
            'date'     => Carbon::now('Asia/Jakarta'),
        ];

        HistoryStock::create($history);
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dibuat!',
            'data' => $product
        ], 201);
    }

    
    public function update_stock(Request $request)
    {
        // dd(substr($request->name,0,3));
       
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'product_id'      => 'required',
            'quantity'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $update = Product::findOrFail($request->product_id);
        $stock = $update->stock + $request->quantity;
        $update->update([
            'stock' => $stock,
        ]);
         //Add History Stock Out when any Tansaction of product
        $history = [
            'toko_store_id' => $request->toko_store_id,
            'product_id' => $request->product_id,
            'type' => "in",
            'quantity'     => $request->quantity,
            'catatan'     => "Penambahan Manual",
            'stock_progress'  => $stock,
            'date'     => Carbon::now('Asia/Jakarta'),
        ];

        HistoryStock::create($history);
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Stock Produk berhasil dibuat!',
        ], 201);
    }
}
