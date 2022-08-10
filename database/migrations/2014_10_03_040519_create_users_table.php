<?php

use Illuminate\Database\Schema\Blueprint;
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
	        $table->increments('id');
	        $table->string('email')->unique();
        	$table->string('password')->nullable();
        	$table->string('name');
        	$table->string('remember_token');
        	$table->boolean('initial_setup_completed');
	        $table->integer('access_level')->nullable(); 
	        // students are null 
	        // teachers are 4,
	        // school admins/dept heads are 3,
	        // principals et al are 2,
	        // admins of this software are 1,
	        // supers, as in the guy who typed this, are 0.
	        
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
