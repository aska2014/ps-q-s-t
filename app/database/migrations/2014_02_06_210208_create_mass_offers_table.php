<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMassOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mass_offers', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
			$table->increments('id');

            $table->string('title');
            $table->text('description');

            $table->integer('start_quantity')->unsigned();
            $table->float('gifts_per_product')->unsigned();

            $table->integer('max_gift_price_id')->unsigned()->nullable();
            $table->foreign('max_gift_price_id')->references('id')->on('prices')->onDelete('SET NULL')->onUpdate('CASCADE');

            $table->dateTime('from_date');
            $table->dateTime('to_date');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mass_offers');
	}

}
