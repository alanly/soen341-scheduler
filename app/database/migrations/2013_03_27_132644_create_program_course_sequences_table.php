<?php

use Illuminate\Database\Migrations\Migration;

class CreateProgramCourseSequencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('program_course_sequences', function($table)
		{
      $table->increments('id');
      $table->integer('program_id');
      $table->integer('course_id');
      $table->integer('semester');
      $table->index('program_id');
      $table->index('semester');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('program_course_sequences');
	}

}
