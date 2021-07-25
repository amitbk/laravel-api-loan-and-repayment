<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Loan;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Repay loan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loan_repay(Request $request)
    {
      // get authenticated user from token
      $user = $request->user();

      // check if user has any outstanding payment
      if( $user->balance() <= 0 )
        abort(404, "User don't have any outstanding payment to pay.");

      // validate for loan id
      $request->validate([
          'loan_id' => 'required|numeric|gt:0|exists:loans,id',
      ]);

      $loan = Loan::find($request->loan_id);

      // Repayment is weekly, so need to calculate weekly amount to pay
      $amount_to_pay = round( $loan->amount/($loan->term*52), 2);

      // save as a Loan transaction
      $transaction = new Transaction;
      $transaction->loan_id = $loan->id;
      $transaction->transaction_type_id = 2; // loan transaction
      $transaction->creditor_id = $user->id;
      $transaction->debtor_id = 1; // loan account
      $transaction->amount = $amount_to_pay;
      $transaction->save();

      // return success message
      return ['success'=> 1, 'message' => 'Weekly loan repayment transaction is successfull.', 'amount_remaining' => $user->balance(), 'amount_paid' => $amount_to_pay];
    }

}
