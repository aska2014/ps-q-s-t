<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigsAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('migs_accounts', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name');

            $table->text('merchant_id');
            $table->text('secret');
            $table->text('access_code');

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
        Schema::drop('migs_accounts');
	}

}