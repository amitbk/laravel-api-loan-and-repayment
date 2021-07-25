<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [App\Http\Controllers\Auth\ApiAuthController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\Auth\ApiAuthController::class, 'logout']);

Route::get('users/{id}/balance', [App\Http\Controllers\UserController::class, 'balance'])->name('balance');


Route::post('loans/apply', [App\Http\Controllers\LoanController::class, 'loan_apply'])->name('loan_apply');
Route::post('loans/approve', [App\Http\Controllers\LoanController::class, 'loan_approve'])->name('loan_approve');

Route::post('transactions/loan/repay', [App\Http\Controllers\TransactionController::class, 'loan_repay'])->name('loan_repay');
