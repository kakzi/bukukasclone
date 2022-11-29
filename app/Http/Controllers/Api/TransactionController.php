<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\HistoryStock;
use Illuminate\Http\Request;
use App\Models\TransactionDetails;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CreditCashFlow;
use App\Models\HistoryCreditCashFlow;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        //nama, email, password
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'toko_store_id' => 'required',
            'type_transaction' => 'required',
            'type_pay' => 'required',
            'methode_catatan' => 'required',
            'nominal_penjualan' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $nominalHpp = $request->nominal_hpp ? : 0;
        $type_pay = $request->type_pay;
        if($type_pay == "lunas"){
            
            $dataTransaksi = array_merge($request->all(), [
                'category_cash_out_id' => $request->category_cash_out_id,
                'nominal_hpp' => $nominalHpp,
                'keuntungan' => $request->nominal_penjualan - $nominalHpp,//
                'note' => $request->note,//
                'payment_id' => $request->payment_id,
                'channel_id' => $request->channel_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'date' => Carbon::now('Asia/Jakarta'),
            ]);
            // dd($dataTransaksi);
            // \DB::beginTransaction();
            DB::beginTransaction();
            $transaction = Transaction::create($dataTransaksi);
            $isEmptyProduct = $request->products;
            if ($isEmptyProduct != null){
                foreach ($request->products as $product) {
                    $update = Product::findOrFail($product['id']);
                    $stock = $update->stock - $product['total_item'];
                    $update->update([
                        'stock' => $stock,
                    ]);
                     //Add History Stock Out when any Tansaction of product
                    $history = [
                        'toko_store_id' => $request->toko_store_id,
                        'product_id' => $product['id'],
                        'type' => "out",
                        'quantity'     => $product['total_item'],
                        'catatan'     => "Transaksi Penjualan",
                        'stock_progress'  => $stock,
                        'date'     => now(),
                    ];
                    HistoryStock::create($history);
                    $detail = [
                        'toko_store_id' => $request->toko_store_id,
                        'transaction_id' => $transaction->id,
                        'product_id' => $product['id'],
                        'total_item' => $product['total_item'],
                        'total_harga' => $product['total_harga'],
                        'catatan' => $product['catatan'],
                    ];
                    TransactionDetails::create($detail);
                }
            }
            if (!empty($transaction)) {
                DB::commit();
                return response()->json([
                    'success' => 1,
                    'message' => 'Transaksi Berhasil',
                    'transaksi' => collect($transaction)
                ]);
            } else {
                DB::rollback();
                return $this->error('Transaksi gagal');
            }
        } else {

            // dd($request->all());
            //Transaksi Pemasukan Belum Lunas
            //Validation
            $validator = Validator::make($request->all(), [
                'category_cash_out_id' => 'required',
                'nama_pelanggan' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $dataTransaksi = array_merge($request->all(), [
                'category_cash_out_id' => $request->category_cash_out_id,
                'nominal_hpp' => $nominalHpp,
                'kentungan' => $request->nominal_penjualan - $nominalHpp,//
                'note' => $request->note,//
                'payment_id' => $request->payment_id,
                'channel_id' => $request->channel_id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'date' => Carbon::now('Asia/Jakarta'),
            ]);
            // \DB::beginTransaction();
            DB::beginTransaction();
            $transaction = Transaction::create($dataTransaksi);
            $isEmptyProduct = $request->products;
            // dd($isEmptyProduct);
            if ($isEmptyProduct != null){
                foreach ($request->products as $product) {
                    $update = Product::findOrFail($product['id']);
                    $stock = $update->stock - $product['total_item'];
                    $update->update([
                        'stock' => $stock,
                    ]);
                     //Add History Stock Out when any Tansaction of product
                    $history = [
                        'toko_store_id' => $request->toko_store_id,
                        'product_id' => $product['id'],
                        'type' => "out",
                        'quantity'     => $product['total_item'],
                        'catatan'     => "Transaksi Penjualan",
                        'stock_progress'  => $stock,
                        'date'     => now(),
                    ];
                    HistoryStock::create($history);
                    $detail = [
                        'toko_store_id' => $request->toko_store_id,
                        'transaction_id' => $transaction->id,
                        'product_id' => $product['id'],
                        'total_item' => $product['total_item'],
                        'total_harga' => $product['total_harga'],
                        'catatan' => $product['catatan'],
                    ];
                    TransactionDetails::create($detail);
                }
            }

            if($request->type_transaction == "pemasukan")
            {
                $namapelanggan = $request->nama_pelanggan;
                $checkingAkun = CreditCashFlow::where('nama_pelanggan', $namapelanggan)->first();
                if($checkingAkun == null){
                    //Hutang/Piutang
                    $piutang = [
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $namapelanggan,
                        'type' => "memberi",
                        'nominal' => $request->nominal_penjualan,
                        'catatan' => "Penjualan",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];
                    // DB::beginTransaction();
                    $transaksiPiutang = CreditCashFlow::create($piutang);

                    $pelanggan = [
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $namapelanggan,
                        'number' => "null",
                    ];
                    // DB::beginTransaction();
                    Pelanggan::create($pelanggan);
                    // dd($transaction->id);
                    //History Hutang
                    $historyPiutang = [
                        'credit_cash_flow_id' => $transaksiPiutang->id,
                        'transaction_id' => $transaction->id,
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $namapelanggan,
                        'type' => "memberi",
                        'nominal' => $request->nominal_penjualan,
                        'nominal_progress' => $request->nominal_penjualan,
                        'catatan' => "Penjualan",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];

                    HistoryCreditCashFlow::create($historyPiutang);

                } else {
                    
                    // dd($checkingAkun->id);
                    $creditcash = CreditCashFlow::findOrFail($checkingAkun->id);
                    $nominal = $creditcash->nominal + $request->nominal_penjualan;
                    $creditcash->update([
                        'nominal' => $nominal,
                    ]);
                    $historyPiutang = [
                        'credit_cash_flow_id' => $checkingAkun->id,
                        'transaction_id' => $transaction->id,
                        'toko_store_id' => $checkingAkun->toko_store_id,
                        'nama_pelanggan' => $namapelanggan,
                        'type' => "memberi",
                        'nominal' => $request->nominal_penjualan,
                        'nominal_progress' => $nominal,
                        'catatan' => "Penjualan",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];

                    HistoryCreditCashFlow::create($historyPiutang);
                }
            
            } else {

                $namapelanggan = $request->nama_pelanggan;
                $checkingAkun = CreditCashFlow::where('nama_pelanggan', $namapelanggan)->first();

                if($checkingAkun == null){
                    //Hutang/Piutang
                    $piutang = [
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'type' => "menerima",
                        'nominal' => $request->nominal_penjualan,
                        'catatan' => "Pengeluaran",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];
                    // DB::beginTransaction();
                    $transaksiPiutang = CreditCashFlow::create($piutang);

                    $pelanggan = [
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'number' => "null",
                    ];
                    // DB::beginTransaction();
                    Pelanggan::create($pelanggan);
                    
                    //History Hutang
                    $historyPiutang = [
                        'credit_cash_flow_id' => $transaksiPiutang->id,
                        'transaction_id' => $transaction->id,
                        'toko_store_id' => $request->toko_store_id,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'type' => "menerima",
                        'nominal' => $request->nominal_penjualan,
                        'catatan' => "Pengeluaran",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];

                    HistoryCreditCashFlow::create($historyPiutang);

                } else {

                    $creditcash = CreditCashFlow::findOrFail($checkingAkun->id);
                    $nominal = $creditcash->nominal - $request->nominal_penjualan;
                    $creditcash->update([
                        'nominal' => $nominal
                    ]);

                    $historyPiutang = [
                        'credit_cash_flow_id' => $checkingAkun->id,
                        'transaction_id' => $transaction->id,
                        'toko_store_id' => $checkingAkun->toko_store_id,
                        'nama_pelanggan' => $request->nama_pelanggan,
                        'type' => "menerima",
                        'nominal' => $request->nominal_penjualan,
                        'nominal_progress' => $nominal,
                        'catatan' => "Penjualan",
                        'date' => Carbon::now('Asia/Jakarta'),
                    ];

                    HistoryCreditCashFlow::create($historyPiutang);

                }
            }

            if (!empty($transaction)) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi Berhasil',
                    'transaksi' => collect($transaction)
                ],201);
            } else {
                DB::rollback();
                return $this->error('Transaksi gagal');
            }
        }
    }

    public function error($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ],401);
    }
}
