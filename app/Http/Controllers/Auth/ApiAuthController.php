<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ApiAuthController extends Controller
{


  public function login(Request $request)
  {
    $request->validate([
        'email' => 'required|email|max:255|exists:users,email',
        'password' => 'required|string|max:255'
    ]);

    if( Auth::attempt(['email'=>$request->email, 'password'=>$request->password]) ) {
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken($user->email.'-'.now());

        return response()->json([
            'token' => $token->accessToken
        ]);
    }
  }

  public function logout(Request $request)
  {
    return $token = $request->user()->token();
    $token->revoke();
    $response = ['message' => 'You have been successfully logged out!'];
    return response($response, 200);
  }
}
