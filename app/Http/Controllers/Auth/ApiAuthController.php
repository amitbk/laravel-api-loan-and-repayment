<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ApiAuthController extends Controller
{


  /**
   * Login API.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    // validate credentials
    $request->validate([
        'email' => 'required|email|max:255|exists:users,email',
        'password' => 'required|string|max:255'
    ]);

    // attemt login
    if( Auth::attempt(['email'=>$request->email, 'password'=>$request->password]) ) {
        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken($user->email.'-'.now());

        return response()->json([
            'user' => $user,
            'token' => $token->accessToken
        ]);
    }
    return abort(401, 'Login failed.');
  }

}
