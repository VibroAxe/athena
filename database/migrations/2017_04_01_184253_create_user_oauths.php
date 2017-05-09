<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOAuths extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_oauths', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')
				->unsigned();

			$table->string('service');

			$table->bigInteger('service_id')
				->nullable();

			$table->string('username')
				->nullable();

			$table->string('avatar')
				->nullable();

			$table->string('token',100)
				->nullable();

			$table->timestamp('tokenexpires')
				->nullable();

			$table->string('refreshtoken',100)
				->nullable();

			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_oauths');
	}

}
