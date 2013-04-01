<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
    Eloquent::unguard();
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
        'university_id' => '0000000',
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
    Program::create( array('description' => 'None') );

    Program::create( array('description' => 'Bachelor of Computer Science') );

    Program::create( array('description' => 'Bachelor of Software Engineering') );
  }

}

class ProgramOptionTableSeeder extends Seeder {

  public function run()
  {
    // Entries for program 1: None
    ProgramOption::create( array('description' => 'None', 'program_id' => 1) );

    // Entries for program 2: Bachelor of Computer Science
    ProgramOption::create( array('description' => 'None', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Computer Games', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Web Services and Applications', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Computer Systems', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Software Systems', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Information Systems', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Computer Applications', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Computation Arts', 'program_id' => 2) );
    ProgramOption::create( array('description' => 'Mathematics and Statistics', 'program_id' => 2) );

    // Entries for program 3: Bachelor of Software Engineering
    ProgramOption::create( array('program_id' => 3, 'description' => 'None') );
    ProgramOption::create( array('program_id' => 3, 'description' => 'Computer Games') );
    ProgramOption::create( array('program_id' => 3, 'description' => 'Real-Time, Embedded, and Avionics Software') );
    ProgramOption::create( array('program_id' => 3, 'description' => 'Web Services and Applications') );

  }

}
