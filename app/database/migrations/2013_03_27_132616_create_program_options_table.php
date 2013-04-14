<?php

use Illuminate\Database\Migrations\Migration;

class CreateProgramOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_options', function($table)
		{
      $table->increments('id');
      $table->string('description');
      $table->integer('program_id');
      $table->index('program_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('program_options');
	}

}
