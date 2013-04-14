<?php

use Illuminate\Database\Migrations\Migration;

class CreateAcademicRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('academic_records', function($table)
		{
      $table->increments('id');
      $table->integer('user_id');
      $table->integer('course_id');
      $table->index('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('academic_records');
	}

}
