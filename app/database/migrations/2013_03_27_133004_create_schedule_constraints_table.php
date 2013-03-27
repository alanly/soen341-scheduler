<?php

use Illuminate\Database\Migrations\Migration;

class CreateScheduleConstraintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('schedule_constraints', function($table)
		{
      $table->increments('id');
      $table->integer('schedule_id');
      $table->string('type');
      $table->text('value');
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
		Schema::drop('schedule_constraints');
	}

}
