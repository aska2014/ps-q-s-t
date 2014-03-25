<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_messages', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('subject');

            $table->text('body');

            $table->integer('user_info_id')->unsigned();
            $table->foreign('user_info_id')->references('id')->on('ka_user_info')->onDelete('CASCADE')->onUpdate('CASCADE');

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
		Schema::drop('contact_messages');
	}

}
