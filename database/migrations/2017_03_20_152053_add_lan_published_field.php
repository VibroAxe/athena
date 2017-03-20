<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanPublishedField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lans', function(Blueprint $table)
		{
			$table->integer('published')
				->default(1)
				->unsigned()
				->after('end');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lans', function(Blueprint $table)
		{
			$table->dropColumn('published');
		});
	}

}
