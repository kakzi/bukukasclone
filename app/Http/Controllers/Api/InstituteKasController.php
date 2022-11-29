<?php

namespace App\Http\Controllers\Api;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Models\MetodePayment;
use App\Models\CategoryCashOut;
use App\Http\Controllers\Controller;
use App\Models\HistoryStock;
use App\Models\Pelanggan;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class InstituteKasController extends Controller
{
    public function channels()
    {
        $channel = Channel::get();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Channel Berhasil',
            'data' => $channel
        ], 200);
    }
    public function metode_payment()
    {
        $metode_payment = MetodePayment::get();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Metode Payment Berhasil',
            'data' => $metode_payment
        ], 200);
    }

    public function cashout_category()
    {
        $cashoucategory = CategoryCashOut::get();
        return response()->json([
            'success' => true,
            'message' => 'Get Data Category Cash Out Berhasil',
            'data' => $cashoucategory
        ], 200);
    }

    
    public function payment(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'nama'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

         //create customer
        MetodePayment::create([
            'toko_store_id' => $request->toko_store_id,
            'name'     => $request->nama,
            'icon'     => "metodepayment.png",
        ]);
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Metode Payment berhasil dibuat!'
        ], 201);
    }

    public function cashout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

         //create customer
        CategoryCashOut::create([
            'toko_store_id'      => $request->toko_store_id,
            'name'     => $request->name,
            'icon'     => "cashoutcategory.png",
        ]);
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Cash Out Category berhasil dibuat!'
        ], 201);
    }
    public function pelanggan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'nama_pelanggan'      => 'required',
            'number'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

         //create customer
        Pelanggan::create([
            'toko_store_id'      => $request->toko_store_id,
            'nama_pelanggan'     => $request->nama_pelanggan,
            'number'     => $request->number,
        ]);
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Pelanggan berhasil dibuat!'
        ], 201);
    }


    public function stock_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'product_id'      => 'required',
            'type'      => 'required',
            'quantity'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $id = $request->product_id;
        $type = $request->type;

        if($type == "in"){
            $product = Product::findOrFail($id);
            $stock = $product->stock + $request->quantity;
            $product->update([
                'stock' => $stock,
            ]);
        } else {
            $product = Product::findOrFail($id);
            $stock = $product->stock - $request->quantity;
            $product->update([
                'stock' => $stock,
            ]);
        }
         //create customer
        $history = HistoryStock::create([
            'toko_store_id' => $request->toko_store_id,
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity'     => $request->quantity,
            'catatan'     => "Penambahan Manual",
            'stock_progress'  => $stock,
            'date'     => now(),
        ]);

        $history->save();
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Stock berhasil diperbaharui!'
        ], 201);
    }

    // $transaksi = Transaction::with(['details.transaction', 'users'])->where('id', $id)->first();

    //     $this->pushNotif('Transaksi Dibatalkan', "Transasi product " . $transaksi->details[0]->product->name . " berhasil dibatalkan", $transaksi->users->fcm);
    //     $transaksi->update([
    //         'status' => "DIKIRIM"
    //     ]);

    //     foreach ($transaksi->details as $p) {

    //         $id = $p->product_id;
    //         //update data tanpa image
    //         $product = Product::findOrFail($id);
    //         $stock = $product->stock - $p->total_item;
    //         $product->update([
    //             'stock'       => $stock,
    //         ]);
    //     }

}
