<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AttachLocationToAccounts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ka_accounts', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->integer('shipping_location_id')->unsigned()->nullable();
            $table->foreign('shipping_location_id')->references('id')->on('locations')->onDelete('SET NULL')->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ka_accounts', function(Blueprint $table)
		{
            $table->dropForeign('ka_accounts_shipping_location_id_foreign');
            $table->dropColumn('shipping_location_id');
		});
	}
}