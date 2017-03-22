<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImgFieldToAchievementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('achievements', function(Blueprint $table)
		{
			$table->text('image')
				->after('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('achievements', function(Blueprint $table)
		{
			$table->dropColumn('image');
		});
	}

}
