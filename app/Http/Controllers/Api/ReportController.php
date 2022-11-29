<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransactionDetails;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function get_sale_today(Request $request){

        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required',
            'toko_store_id'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $today = Carbon::now('Asia/Jakarta');
        $yesterday = $today->yesterday();

        $salesToday = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pemasukan')
                        ->whereDate('date',  $today)
                        ->sum('nominal_penjualan');
        $salesYesterday = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pemasukan')
                        ->whereDate('date',  $yesterday)
                        ->sum('nominal_penjualan');

        $cashToday = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pengeluaran')
                        ->whereDate('date',  $today)
                        ->sum('nominal_penjualan');
        $cashYesterday = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pengeluaran')
                        ->whereDate('date',  $yesterday)
                        ->sum('nominal_penjualan');

        $untungHariIni = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pemasukan')
                        ->whereDate('date',  $today)
                        ->sum('keuntungan');
        $untungKemarin = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->where('type_transaction', 'pemasukan')
                        ->whereDate('date',  $yesterday)
                        ->sum('keuntungan');
        $todayTransaksi = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->whereDate('date',  $today)
                        ->count();
        $yesterdayTransaksi = Transaction::where('customer_id', $request->customer_id)
                        ->where('toko_store_id', $request->toko_store_id)
                        ->whereDate('date',  $yesterday)
                        ->count();
        $produkHariIni = TransactionDetails::where('toko_store_id', $request->toko_store_id)
                        ->whereDate('created_at',  $today)
                        ->groupBy('product_id')
                        ->selectRaw('product_id, sum(total_item) as total_terjual')
                        ->orderBy('total_terjual', 'DESC')->limit(1)->first();
                        
        if ($salesYesterday == 0){
            $kenaikan = $salesToday - $salesYesterday;
            $percentage =  "0";
        } else {
            $kenaikan = $salesToday - $salesYesterday;
            $percentage =  (($salesToday - $salesYesterday))/$salesYesterday * 100;
        }

        if ($cashYesterday == 0){
            $kenaikanCash = $cashToday - $cashYesterday;
            $percentageCash =  "0";
        } else {
            $kenaikanCash = $cashToday - $cashYesterday;
            $percentageCash =  (($cashToday - $cashYesterday))/$cashYesterday * 100;
        }

        if ($untungKemarin == 0){
            $kenaikanUntung = $untungHariIni - $untungKemarin;
            $percentageUntung =  "0";
        } else {
            $kenaikanUntung = $untungHariIni - $untungKemarin;
            $percentageUntung =  (($untungHariIni - $untungKemarin))/$untungKemarin * 100;
        }
        if ($yesterdayTransaksi == 0){
            $kenaikanTransaksi = $todayTransaksi - $yesterdayTransaksi;
            $percentageTransaksi =  "0";
        } else {
            $kenaikanTransaksi = $todayTransaksi - $yesterdayTransaksi;
            $percentageTransaksi =  (($todayTransaksi - $yesterdayTransaksi))/$yesterdayTransaksi * 100;
        }

        if($produkHariIni == null){
            $product = [
                "name" => null,
                "quantity" => 0
            ];
        } else {
            $product = Product::where('id', $produkHariIni->product_id)->first();
            $product = [
                "name" => $product->name,
                "quantity" => $produkHariIni->total_terjual
            ];
        }
        $sales = [
            "today" => $salesToday,
            "yesterday" => $salesYesterday,
            "kenaikan" => $kenaikan,
            "percentage" => $percentage ."%"
        ];
        $transaksi = [
            "today" => $todayTransaksi,
            "yesterday" => $yesterdayTransaksi,
            "kenaikan" => $kenaikanTransaksi,
            "percentage" => $percentageTransaksi."%"
        ];
        $cash = [
            "today" => $cashToday,
            "yesterday" => $cashYesterday,
            "kenaikan" => $kenaikanCash,
            "percentage" => $percentageCash."%"
        ];
        $untung = [
            "today" => $untungHariIni,
            "yesterday" => $untungKemarin,
            "kenaikan" => $kenaikanUntung,
            "percentage" => $percentageUntung."%"
        ];

        $json = [
            "pemasukan" => $sales,
            "pengeluaran" => $cash,
            "keuntungan" => $untung,
            "product" => $product,
            "transaksi" => $transaksi,
        ];

        return response()->json([
            'success' => true,
            'message' => "Transaction report today!",
            'data' => $json
        ], 201);

    }

    public function message($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ],401);
    }
}
