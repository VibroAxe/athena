<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slides', function(Blueprint $table)
    {
      //Fields
      $table->increments('id');

      $table->integer('parent_id')
        ->nullable()
        ->unsigned();

      $table->string('title');

      $table->string('url')
        ->nullable();

      $table->text('content')
        ->nullable();

      $table->integer('position')
        ->unsigned()
        ->nullable();

      $table->integer('published')
        ->default(1)
        ->unsigned();

      $table->integer('timespan')
        ->default(30)
        ->unsigned();

      $table->timestamp('startdate')
        ->nullable();

      $table->timestamp('enddate')
        ->nullable();

      $table->timestamp('starttime')
        ->nullable();

      $table->timestamp('endtime')
        ->nullable();

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
		Schema::drop('slides');
	}

}
