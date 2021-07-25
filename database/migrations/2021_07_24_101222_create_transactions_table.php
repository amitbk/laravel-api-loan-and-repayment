<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('transaction_type_id')->unsigned();
            $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('cascade');

            $table->unsignedBigInteger('loan_id')->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');

            $table->unsignedBigInteger('creditor_id')->unsigned();
            $table->foreign('creditor_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('debtor_id')->unsigned();
            $table->foreign('debtor_id')->references('id')->on('users')->onDelete('cascade');

            // reference transaction id for Repayment
            $table->unsignedBigInteger('transaction_id')->unsigned()->nullable()->default(null);
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');

            $table->double('amount');
            $table->boolean('is_approved')->default(0);
            $table->string('naration')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
