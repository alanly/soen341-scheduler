<?php

use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_sections', function($table)
		{
      $table->increments('id');
      $table->integer('course_id')->index();
      $table->string('code');
      $table->integer('session_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_sections');
	}

}
