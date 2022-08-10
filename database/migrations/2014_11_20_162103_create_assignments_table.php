<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assignments', function($table)
	    {
	        $table->increments('id');
	        $table->string('name');
	        $table->longText('content');
	        $table->boolean('has_submissions');
	        $table->integer('owner_id');
	        $table->float('weight')->nullable();
	        $table->dateTime('due');

	        $table->integer('classroom_id');
	        
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
		Schema::drop('assignments');
	}

}
