<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Updatelans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lans', function($table)
		{
			$table->integer('achievement_id')
				->unsigned()
				->nullable()
				->after('achievement_id');

			$table->text('iprange')
				->nullable()
				->after('achievement_id');

			$table->foreign('achievement_id')
				->references('id')
				->on('achievements')
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
		Schema::table('lans', function($table)
		{
			$table->dropColumn('achievement_id');
			$table->dropColumn('iprange');
		});
	}

}
