<?php

class DDBYTest extends TestCase {
	
	public function testLogin() {
		// Login.
		$this->call('POST', '/login', array('email' => 'admin@admin.com', 'password' => 'admin'));
		
		
		//****************Login Test******************//
		$this->assertTrue(Auth::check(), 'Login not successful.');
	
		
		//*****************Home Redirect Test*****************//
		$this->assertRedirectedTo('/');
		
		
		// Logout.
		$this->call('GET', '/logout');
		
		
		//***************Logout Test*******************//
		$this->assertTrue(Auth::guest(), 'Logout not successful.');
	}
	
	public function testAccount() {
		// Create account.
		$this->call('POST', '/register', array('name' => 'Michael Lavoie',
    										'email' => 'lavoie6453@hotmail.com',
											'id' => '9778004',
											'password' => '123456',
											'password_confirmation' => '123456',
											'program' => 3,
											'program_option' => 12));
		
		
		//**************Account Creation Test******************//
		$this->assertTrue(Auth::check(), 'Account creation was not successful.');
		
		
		// Keep userId for later.
		$userId = Auth::user()->id;
		
		// Login with Admin Account.
		$this->call('POST', '/login', array('email' => 'admin@admin.com', 'password' => 'admin'));
		
		// Promote the created user.
		$this->call('PUT', "/admin/user/$userId");

		
		//*****************User Promotion Test*******************//
		$this->assertTrue((User::find($userId)->is_admin == 1), 'User promotion was not succesful.');
		
		
		// Demote.
		$this->call('PUT', "/admin/user/$userId");
		
		
		//*****************User Demotion Test*******************//
		$this->assertTrue((User::find($userId)->is_admin == 0), 'User demotion was not succesful.');
		
		
		// Delete the previously created user.
		$this->call('DELETE', "/admin/user/$userId");
		
		
		//****************Account Deletion Test*******************//
		$this->assertTrue((is_null(User::find($userId))), 'User deletion was not successful.');
	
	}

	public function testProgram() {
		// Login with Admin Account.
		$this->call('POST', '/login', array('email' => 'admin@admin.com', 'password' => 'admin'));
		
		// Create Program.
		$response = $this->action('POST', 'AdminProgramController@store', array('description' => 'This is a program description.'));
	}
	
	

}