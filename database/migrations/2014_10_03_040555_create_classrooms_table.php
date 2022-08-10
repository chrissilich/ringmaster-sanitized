<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('classrooms', function($table)
	    {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('code');
	        $table->string('description');
	        $table->integer('owner_id');
	        $table->integer('department_id');
	        $table->date('start_date');
	        $table->date('end_date');
	        
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
		Schema::drop('classrooms');
	}

}
