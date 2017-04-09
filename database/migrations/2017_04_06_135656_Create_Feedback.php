<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedback extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedbacks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('priority');
			$table->text('feedback');
			$table->integer('user_id')
				->unsigned()
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
		Schema::drop('feedbacks');
	}

}
