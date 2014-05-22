<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigsTransations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('migs_transactions', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('vpc_Amount');
            $table->string('vpc_Currency');
            $table->string('vpc_AuthorizeId');
            $table->string('vpc_BatchNo');
            $table->string('vpc_Card');
            $table->string('vpc_CardNum');
            $table->string('vpc_ReceiptNo');
            $table->string('vpc_TransactionNo');

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
		Schema::drop('migs_transactions');
	}

}
