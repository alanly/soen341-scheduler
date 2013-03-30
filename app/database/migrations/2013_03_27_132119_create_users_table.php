<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
  {
      $table->string('id')->unique();
      $table->string('email')->unique();
      $table->string('password');
      $table->string('name');
      $table->integer('is_admin')->default(0);
      $table->integer('program_id');
      $table->integer('option_id');
      $table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
