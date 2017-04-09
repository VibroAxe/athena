<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMPUKUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('MPUKUsers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username');
			$table->string('fullname');
			$table->string('email');
			$table->integer('total');
			$table->string('rank');
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
		Schema::drop('MPUKUsers');
	}

}
