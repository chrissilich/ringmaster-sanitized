<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function($table)
	    {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('content');
	        $table->boolean('has_submissions');
	        $table->integer('owner_id');
	        $table->dateTime('start');
	        $table->dateTime('end');

	        $table->integer('classroom_id')->nullable();
	        $table->integer('department_id')->nullable();
	        
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
		Schema::drop('events');
	}

}
