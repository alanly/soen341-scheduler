<?php

use Illuminate\Database\Migrations\Migration;

class CreateProgramOptionCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_option_courses', function($table)
		{
      $table->increments('id');
      $table->integer('program_option_id');
      $table->integer('course_id');
      $table->index('program_option_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('program_option_courses');
	}

}
