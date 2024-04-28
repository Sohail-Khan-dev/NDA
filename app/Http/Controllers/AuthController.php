<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string',
            'dob' => 'nullable|date',
            'id_number' => 'nullable|string',
            'password' => 'required|string|min:6',
//            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'id_number' => $request->id_number,
            'password' => Hash::make($request->password),
//            'confirm_password' => Hash::make($request->password),
        ]);
        if ($request->expectsJson()) {
            return response()->json(['message' => 'User registered successfully', 'user' => $user]);
        } else {
            $users = User::all();
            return redirect('/')->with('success', 'User registered successfully','users',$users);
        }
//        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
//        return $request ; //  response()->json(['credentials: ' => $request->all()]);
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials theek da credentials'], 401);
    }


    public function fetchAllUsers(){
        $users = User::all();
        return response()->json([
           'users' => $users
        ]);

    }

}
