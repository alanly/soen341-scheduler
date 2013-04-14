<?php

use Illuminate\Database\Migrations\Migration;

class CreateCourseTimeslotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_timeslots', function($table)
		{
      $table->increments('id');
      $table->integer('course_id');
      $table->integer('section_id');
      $table->string('type');
      $table->string('code');
      $table->string('location');
      $table->string('instructor');
      $table->integer('day');
      $table->string('start_time');
      $table->string('end_time');
      $table->index('course_id');
      $table->index('section_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_timeslots');
	}

}
