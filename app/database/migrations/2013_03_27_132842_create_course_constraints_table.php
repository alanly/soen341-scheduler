<?php

use Illuminate\Database\Migrations\Migration;

class CreateCourseConstraintsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_constraints', function($table)
		{
      $table->increments('id');
      $table->integer('course_id');
      $table->string('type');
      $table->text('value');
      $table->index('course_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_constraints');
	}

}
