<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustSteamAppIdNull extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `applications` MODIFY `steam_app_id` INTEGER(11) NULL');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('applications', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `applications` MODIFY `steam_app_id` INTEGER(11) NOT NULL');
		});
	}

}
