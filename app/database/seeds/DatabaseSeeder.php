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
    $this->call('ProgramTableSeeder');
    $this->call('ProgramOptionTableSeeder');
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
        'program_id' => 1,
        'option_id' => 1
      )
    );
  }

}

class ProgramTableSeeder extends Seeder {

  public function run()
  {
    Program::create(
      array(
        'description' => 'None'
      )
    );
  }

}

class ProgramOptionTableSeeder extends Seeder {

  public function run()
  {
    ProgramOption::create(
      array(
        'description' => 'None',
        'program_id' => 1
      )
    );
  }

}
