<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function profile(){

        if (Auth::user()){
            return response()->json([
                'profile' => Auth::user(),
                'status_code' => 200,
            ], 200);
        } else{
            return response()->json([
                'message' => 'Not login to system.',
                'status_code' => 500,

            ], 500);
        }
    }

    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()){
            return response()->json([
                'message' => 'User Created Successfully.',
                'status_code' => 201,

            ], 201);
        } else {
            return  response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,

            ], 500);
        }
    }

    public function login(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember_me' => 'boolean',
        ]);

        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message'=>'Unauthorised! Invalid Email or Password.',
                'status_code' => 401,
            ], 401);
        }

        $user = Auth::user();

        if ($user->role = 'administrator'){
            $tokenData = $user->createToken('Personal Access Token', ['do_anything']);
        } else {
            $tokenData = $user->createToken('Personal Access Token', ['can_create']);
        }

        $token = $tokenData->token;

        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeek(1);
        }

        if ($token->save()){
            return response()->json([
                'user' => $user,
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $tokenData->token->scopes[0],
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some error accrued! Please try again.',
                'status_code' => 500,
            ], 500);
        }

    }

    public function logout(Request $request){
        Auth::user()->token()->revoke();
        return response()->json([
            'message' => 'Logout successfully.',
            'status_code' => 200,
        ], 200);
    }
}
