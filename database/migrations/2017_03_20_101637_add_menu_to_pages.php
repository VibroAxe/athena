<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMenuToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function(Blueprint $table)
		{
      //
      $table->string('menu')
        ->nullable()
        ->default('info')
        ->after('position');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pages', function(Blueprint $table)
		{
      //
      $table->dropColumn('menu');
		});
	}

}
