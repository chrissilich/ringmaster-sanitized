<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentSubmissionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignment_submissions', function($table)
	    {
	        $table->increments('id');
	        $table->string('content')->nullable();

	        $table->integer('assignment_id');
	        $table->integer('owner_id');
	        
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
		Schema::drop('grades');
	}

}
