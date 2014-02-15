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
            $table->float('start_price')->unsigned();

            $table->float('max_gift_price')->unsigned();
            $table->float('gifts_per_product')->unsigned();

            $table->float('discount_percentage');

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
