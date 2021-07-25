<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Transaction;
use Illuminate\Http\Request;

class LoanController extends Controller
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
     * Apply for loan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loan_apply(Request $request)
    {
      // get authenticated user from token
      $user = $request->user();

      // validate for amount and term
      $request->validate([
          'amount' => 'required|numeric|gt:0',
          'term' => 'required|numeric|gt:0'
      ]);

      // save as a Loan transaction
      $loan = new Loan;
      $loan->user_id = $user->id;
      $loan->amount = $request->amount;
      $loan->term = $request->term;
      $loan->save();

      // return success message
      return ['success'=> 1, 'message' => 'Loan application submitted successfully.', 'loan' => $loan];
    }


    /**
     * Approve loan.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loan_approve(Request $request)
    {
      // get authenticated user from token
      $user = $request->user();

      // validate for loan_id
      $request->validate([
          'loan_id' => 'required|numeric|gt:0|exists:loans,id',
      ]);

      // approve loan
      $loan = Loan::find($request->loan_id);
      $loan->is_approved = 1;
      $loan->approved_by_id = $user->id;
      $loan->save();

      // create transaction
      $transaction = new Transaction;
      $transaction->loan_id = $loan->id; // loan transaction
      $transaction->transaction_type_id = 1; // loan transaction
      $transaction->creditor_id = 1; // loan account
      $transaction->debtor_id = $loan->user_id;
      $transaction->amount = $loan->amount;
      $transaction->save();

      // return success message
      return ['success'=> 1, 'message' => 'Loan approved successfully.', 'loan' => $loan];
    }
}
