<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
	  $this->call('UserTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

  public function run()
  {
    User::create(
      array(
        'id' => '0000000',
        'email' => 'admin@admin.com',
        'password' => Hash::make('admin'),
        'name' => 'Administrator',
        'is_admin' => 1,
        'program_id' => null,
        'option_id' => null
      )
    );
  }

}
