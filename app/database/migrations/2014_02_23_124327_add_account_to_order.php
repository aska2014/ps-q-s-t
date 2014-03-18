<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountToOrder extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->integer('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('ka_accounts')->onDelete('SET NULL')->onUpdate('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function(Blueprint $table)
		{
            $table->dropForeign('orders_account_id_foreign');
            $table->dropColumn('account_id');
		});
	}

}