<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


  /**
   * Get user balance amount.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function balance($id)
  {
    return [ 'balance' => User::find($id)->balance() ];
  }
}
