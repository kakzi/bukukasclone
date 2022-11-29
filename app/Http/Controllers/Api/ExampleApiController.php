<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExampleApiController extends Controller
{
    // Auth
     /**
     * register
     *
     * @param  mixed $request
     * @return void
     */
    // public function register(Request $request)
    // {
    //     //set validasi
    //     $validator = Validator::make($request->all(), [
    //         'name'      => 'required',
    //         'email'     => 'required|email|unique:customers',
    //         'password'  => 'required|min:8|confirmed',
    //         'pin_secure'  => 'required|min:6',
    //         'phone' => 'required|unique:customers'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

    //     $pin_secure = Hash::make($request->pin_secure . $request->email);
    //     $random_one = rand(1000,5000);
    //     $random_two = rand(6000,9000);
    //     $nomor_rekening = '1100'.$random_one.$random_two;

    //     $nmid = encrypt('nmid'.$nomor_rekening.$request->email);
    //     // $test_lagi = decrypt($test);
    //     // dd($test_lagi);
   
    //     //create customer
    //     $customer = Customer::create([
    //         'name'      => $request->name,
    //         'email'     => $request->email,
    //         'phone'     => $request->phone,
    //         'password'  => Hash::make($request->password),
    //         'pin_secure'  => $pin_secure,
    //         'nomor_rekening' => $nomor_rekening,
    //         'nmid' =>  $nmid
    //     ]);

    //     $customer = Customer::where('email', $request->email)->first();

    //     //return JSON
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Register Berhasil!',
    //         'customer'    => $customer,
    //         'token'   => $customer->createToken('authToken')->accessToken
    //     ], 201);
    // }

    // /* login
    // *
    // * @param  mixed $request
    // * @return void
    // */
    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email'     => 'required',
    //         'password'  => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

    //     $customer = Customer::where('email', $request->email)->first();

    //     if (!$customer || !Hash::check($request->password, $customer->password)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email dan Password tidak di temukan!',
    //         ], 401);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Login Berhasil!',
    //         'user'    => $customer,
    //         'token' => $customer->createToken('authToken')->accessToken
    //     ], 200);
    // }

    // public function get_saldo_balance_user()
    // {
       
    //     $customer_id = auth()->guard('api')->user()->id;
    //     $customer = Customer::where('id', $customer_id)->first();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Saldo kamu!',
    //         'balance' => $customer->balance
    //     ], 200);
    // }


    // public function get_nmid(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email'     => 'required',
    //         'pin_secure' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

    //     $customer = Customer::where('email', $request->email)->first();

    //     if (!$customer || !Hash::check($request->pin_secure.$request->email, $customer->pin_secure)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Pin Salah!',
    //         ], 401);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Get NMID Success!',
    //         'nmid'    => $customer->nmid
    //     ], 200);
    // }

    // public function transfers(Request $request){

    //     $validator = Validator::make($request->all(), [
    //         'nominal' => 'required',
    //         'nmid' => 'required',
    //         'pin_secure'=> 'required',
    //         'email'=> 'required'
    //     ]);

    //     $min_transfer = $request->nominal;
    //     if($min_transfer < 5000){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Maaf, Minimal Transfer 5000!',
    //         ], 401);
    //     }

        
    //     if($validator->fails()){
    //         return response()->json($validator->errors(), 400);
    //     }

    //     $customer = Customer::where('email', $request->email)->first();

    //     if (!$customer || !Hash::check($request->pin_secure.$request->email, $customer->pin_secure)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Pin Salah!',
    //         ], 401);
    //     }

    //     $saldo = $customer->balance;
    //     if($saldo < 0 || $saldo < 5000){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Maaf saldo kamu tidak mencukupi!',
    //         ], 401);
    //     }
        
    //     $nomor_rekening = decrypt($request->nmid);
    //     $number = substr($nomor_rekening,4,12);
    //       //save to DB
    //     $transfer = Transfer::create([
    //         'id_customer'  => $customer->id,
    //         'nmid'   => $request->nmid,
    //         'nomor_rekening'   => $number,
    //         'nominal'   => $request->nominal,
    //         'catatan'   => $request->catatan
    //     ]);

    //     if($transfer){
    //         $customers = Customer::where('nomor_rekening', $number)->first();
    //         if (!$customers) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Nomor Rekening tidak ada!',
    //             ], 401);
    //         }
    //         $customers->update([
    //             'balance'   => $customers->balance + $request->nominal,
    //         ]);

    //         $customer->update([
    //             'balance'   => $customer->balance - $request->nominal,
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Transfer sukses!',
    //         ], 200);        
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Transfer gagal!',
    //     ], 401);      

    // }

    // /**
    //     * logout
    //     *
    //     * @param  mixed $request
    //     * @return void
    //     */
    // public function logout(Request $request)
    // {
    //     $removeToken = $request->user()->tokens()->delete();

    //     if ($removeToken) {
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Logout Berhasil!',
    //         ]);
    //     }
    // }

    // public function upload(Request $request)
    // {

    //     $customer = Customer::where('id', auth()->user()->id)->first();

    //     if ($customer) {
    //         $filename = '';
    //         if ($request->image->getClientOriginalName()) {
    //             $file = str_replace(' ', '', $request->image->getClientOriginalName());
    //             $filename = date('mYdHs') . rand(1, 999) . '-' . $file;
    //             $request->image->storeAs('public/customers', $filename);
    //         } else {
    //             return $this->error('Gagal memuat data');
    //         }

    //         $customer->update([
    //             'avatar' => $filename
    //         ]);

    //         return response()->json([
    //             'success' => 1,
    //             'message' => 'Upload Bukti Transfer Berhasil',
    //             'avatar' => $filename
    //         ]);
    //     } else {
    //         return $this->error('Gagal memuat data');
    //     }
    // }


    // public function error($pesan)
    // {
    //     return response()->json([
    //         'success' => 0,
    //         'message' => $pesan
    //     ]);
    // }
}
