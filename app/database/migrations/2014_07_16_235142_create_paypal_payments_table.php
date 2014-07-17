<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paypal_payments', function(Blueprint $table)
		{
            $table->increments('id');

            $table->integer('status');
            $table->string('token');
            $table->string('transaction_id');

            $table->string('currency');

            $table->float('gross_amount');
            $table->float('fee_amount');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('paypal_payments');
	}

}