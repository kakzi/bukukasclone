<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\HistoryStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CreditCashFlow;
use Illuminate\Support\Facades\Validator;

class CreditCashController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'nama_pelanggan'      => 'required',
            'type'      => 'required',
            'nominal'      => 'required',
            'catatan'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $type = $request->type;
        $nama_pelanggan = $request->nama_pelanggan;

        if( $type == "memberi" ){

            $check = CreditCashFlow::findOrFail($nama_pelanggan);
            if($check != null){
                $nominal = $check->nominal + $request->nominal;
                $check->update([
                    'nominal' => $nominal,
                ]);

                //Add History Stock Out when any Tansaction of product
                $history = [
                    'credit_cash_flow_id' => $check->id,
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type' => $request->type,
                    'nominal'     => $request->nominal,
                    'nominal_progress'     => $nominal,
                    'catatan'  => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ];
        
                HistoryStock::create($history);

            } else {

                $credit = CreditCashFlow::create([
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type'     => $request->type,
                    'nominal'     => $request->nominal,
                    'catatan'     => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ]);

                //Add History Stock Out when any Tansaction of product
                $history = [
                    'credit_cash_flow_id' => $credit->id,
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type' => $request->type,
                    'nominal'     => $request->nominal,
                    'nominal_progress'     => $request->nominal,
                    'catatan'  => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ];
        
                HistoryStock::create($history);

            }
        } else {
            //menerima
            $check = CreditCashFlow::findOrFail($nama_pelanggan);

            if($check != null){

                $nominal = $check->nominal - $request->nominal;
                $check->update([
                    'nominal' => $nominal,
                ]);

                //Add History Stock Out when any Tansaction of product
                $history = [
                    'credit_cash_flow_id' => $check->id,
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type' => $request->type,
                    'nominal'     => $request->nominal,
                    'nominal_progress'     => $nominal,
                    'catatan'  => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ];
                HistoryStock::create($history);

            } else {
                
                $credit = CreditCashFlow::create([
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type'     => $request->type,
                    'nominal'     => $request->nominal,
                    'catatan'     => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ]);

                //Add History Stock Out when any Tansaction of product
                $history = [
                    'credit_cash_flow_id' => $credit->id,
                    'toko_store_id' => $request->toko_store_id,
                    'nama_pelanggan'     => $request->nama_pelanggan,
                    'type' => $request->type,
                    'nominal'     => $request->nominal,
                    'nominal_progress'     => $request->nominal,
                    'catatan'  => $request->catatan,
                    'date'     => Carbon::now('Asia/Jakarta'),
                ];
        
                HistoryStock::create($history);

            }

        }
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Catatan Hutang berhasil dibuat!'
        ], 201);
    }


    public function history_credit(Request $request){
        
        $validator = Validator::make($request->all(), [
            'toko_store_id'      => 'required',
            'nama_pelanggan'      => 'required',
            'type'      => 'required',
            'nominal'      => 'required',
            'catatan'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $type = $request->type;
        $nama_pelanggan = $request->nama_pelanggan;

        if( $type == "memberi" ){

            $check = CreditCashFlow::findOrFail($nama_pelanggan);
            $nominal = $check->nominal + $request->nominal;
            $check->update([
                'nominal' => $nominal,
            ]);

            //Add History Stock Out when any Tansaction of product
            $history = [
                'credit_cash_flow_id' => $check->id,
                'toko_store_id' => $request->toko_store_id,
                'nama_pelanggan'     => $request->nama_pelanggan,
                'type' => $request->type,
                'nominal'     => $request->nominal,
                'nominal_progress'     => $nominal,
                'catatan'  => $request->catatan,
                'date'     => Carbon::now('Asia/Jakarta'),
            ];
    
            HistoryStock::create($history);
        
        } else {
            //menerima
            $check = CreditCashFlow::findOrFail($nama_pelanggan);
            $nominal = $check->nominal - $request->nominal;
            $check->update([
                'nominal' => $nominal,
            ]);
            //Add History Stock Out when any Tansaction of product
            $history = [
                'credit_cash_flow_id' => $check->id,
                'toko_store_id' => $request->toko_store_id,
                'nama_pelanggan'     => $request->nama_pelanggan,
                'type' => $request->type,
                'nominal'     => $request->nominal,
                'nominal_progress'     => $nominal,
                'catatan'  => $request->catatan,
                'date'     => Carbon::now('Asia/Jakarta'),
            ];
            HistoryStock::create($history);
        }
         //return JSON
        return response()->json([
            'success' => true,
            'message' => 'Catatan Hutang berhasil dibuat!'
        ], 201);
    }
}
