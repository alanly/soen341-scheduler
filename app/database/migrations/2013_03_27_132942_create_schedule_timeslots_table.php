<?php

use Illuminate\Database\Migrations\Migration;

class CreateScheduleTimeslotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_timeslots', function($table)
		{
      $table->increments('id');
      $table->integer('schedule_id');
      $table->integer('course_timeslot_id');
      $table->index('schedule_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('schedule_timeslots');
	}

}
