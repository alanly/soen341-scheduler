<?php

use Illuminate\Database\Migrations\Migration;

class CreateSchoolSessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('school_sessions', function($table)
		{
      $table->increments('id');
      $table->string('code')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('school_sessions');
	}

}
