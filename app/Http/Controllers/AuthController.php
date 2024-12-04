<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\optemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $otp = rand(100000,999999);
        // dd("otp is : " + $otp);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string',
            'dob' => 'nullable|date',
            'id_number' => 'nullable|string',
            'password' => 'required|string|min:6',
        ]);
        // If validation fails, return a 422 response with errors
        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Validation errors', 'errors' => $validator->errors()], 422);
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'id_number' => $request->id_number,
                'password' => Hash::make($request->password),
                'one_time_password' => $otp
            ]);
            if($user){
                $this->sendEmail($request->email,$user->name,$otp);
            }
            return response()->json(['status' => 200, 'message' => 'User registered successfully', 'user' => $user], 200);
        }catch (\Exception $e) {
            // Return a 500 response if there's a server error
            return response()->json(['status' => 500, 'message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    private function sendEmail($email, $name, $otp){
        $email =  Mail::to($email)->send(new optemail("Hi {{$name}},

        Your One-Time Password (OTP) for accessing AMS is:

        {{$otp}}

        This code is valid for the one time. Please do not share it with anyone.

        If you did not request this, please ignore this email or contact our support team immediately.

        Thank you,
        AMS Team","Your OTP Code for Secure Access"));
    }

    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 422, 'message' => 'Validation errors', 'errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        try {
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Login successful',
                    'user' => $user, 'token' => $token]);
            }
            return response()->json(['status'=>401 ,'message' => 'Invalid credentials theek da credentials'], 401);
        }catch (\Exception $e)
        {
            return response()->json(['status' => 500, 'message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
    public function verifyOtp(Request $request ){
         $user = User::find(auth()->user()->id);
        $storeOtp = User::find(auth()->user()->id)->pluck('one_time_password')->first();
        if($storeOtp === $request->otp){
            $user->is_verified = true;
            $user->save();
            if($request->expectsJson()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Verified Successfull',
                    'data' => [
                    ]
                ],200);
            }else {
                $users = \App\Models\User::all();
                return redirect()->route('home')->with('users', User::all());
            }            
        }else{
            if($request->expectsJson()){
                return response()->json([
                    'status' => 500,
                    'message' => 'The OTP entered is incorrect'
                ],422);
            }else {
                return redirect()->back()->withErrors(['otp' => 'The OTP entered is incorrect.']);
            }
        }
    }
    public function resendOtp(Request $request){
        $user = auth()->user();
        $otp = rand(100000, 999999);
        $user->one_time_password = $otp;    
        $user->save();
        
        $this->sendEmail($user->email,$user->name,$user->otp);
        return redirect()->back()->with([
            'message' => 'The OTP has been sent successfully. '. $otp,
            'alert-type' => 'success' // or 'danger', 'warning', etc.
        ]);
    }

    public function fetchAllUsers(){
        $users = User::all();
        return response()->json([
           'users' => $users
        ]);

    }
    public function index(){
        $users = \App\Models\User::all();
        if(auth()->user()->is_verified || auth()->user()->is_verified === 1) {
            // dump(auth()->user()->is_verified);
            return view('index',compact('users'));
        }
        else
            return view('auth.otp');
    }

}
