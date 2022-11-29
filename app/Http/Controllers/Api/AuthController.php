<?php

namespace App\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function forbidden(){
        return response()->json([
            'success' => false,
            'message' => 'Token is Expired, Please login again!',
        ], 403);
    }

    public function send_otp(Request $request){
        $validator = Validator::make($request->all(),[
            'whatsapp' => 'required|numeric',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $otp = rand(1000,9999);
        $message = "Assalamualaikum wr. wb. \n_*Aplikasi Institute Kas*_ \nKode OTP kamu ialah : *". $otp . "*,\nSegera Aktifasi akunmu, Kode OTP hanya berlaku *satu menit*. \n\n _*BMT NU Ngasem Institute | Bantu Bisnis Naik Kelas*_" ;
        $number = $request->whatsapp; 

        $customer = Customer::where('phone', $request->whatsapp)->first();
        $dt = Carbon::now('Asia/Jakarta');
        $more = $dt->addMinute();
        if($customer != null){
            $customer->update([
                'otp_code' => $otp,
                'generate_code' => $dt,
                'expired_code' => $more
            ]);
            $dataPesan = [
                // 'token'  => 'nadeen-store',
                'number'  => $number,
                'message' => $message 
            ];
            // $dataPesan = [
            //     'token'  => 'nadeen-store',
            //     'number'  => $number,
            //     'text' => $message 
            // ];
            //API URL
            // $url = 'http://localhost:3000/api/whatsapp/send-text';

            $url = 'http://127.0.0.1:8080/send-message';
            //create a new cURL resource
            $ch = curl_init($url);
            $payload = json_encode($dataPesan);
            //attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            //set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Basic S2Fremktc2VydmVyLXVVZGtmZ2xpNzgzcGtmbmxhc2tvZ29pZ2hyOg=='));
            //return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //execute the POST request
            $response = curl_exec($ch);
            //close cURL resource
            curl_close($ch);
            // dd($response);
            if($response != null){
                return response()->json([
                    'success' => true,
                    'message' => "Otp Berhasil di kirim!"
                ],200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Ada yang bermasalah dengan WhatsApp API!"
                ],400);
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => "Nomor Belum terdaftar!"
            ],403);
        }
    }

    public function verify_otp(Request $request){

        $validator = Validator::make($request->all(),[
            'phone' => 'required|numeric',
            'otp_code' => 'required|numeric',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $number = $request->phone; 
        $date = Carbon::now('Asia/Jakarta');
        
        $customer = Customer::where('phone', $number)->first();
        $expired = $customer->expired_code;
        $otp = $customer->otp_code;

        if($otp == $request->otp_code){
            if($date > $expired){
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP Kamu sudah kadaluarsa, silahkan request ulang!'
                ], 400);
            } else {
                $customer->update([
                    'is_activate' => "activated",
                    'otp_code' => null,
                    'generate_code' => null,
                    'expired_code' => null
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Aktivasi berhasil, Terima kasih!'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Otp Salah!'
            ], 400);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|unique:customers',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password)
         ]);

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $customer,
            'access_token' => $token, 
            'token_type' => 'Bearer', 
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $customer = Customer::where('email', $request->email)->first();
        
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email dan Password tidak di temukan!',
            ], 401);
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Hi '.$customer->name.', welcome to home',
            'access_token' => $token,
            'data' => $customer
        ]);
    }

    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $customer = Customer::where('id', $request->id)->first();
        
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Profile tidak di temukan!',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => "Get Profile successfully!",
            'data' => $customer
        ]);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
