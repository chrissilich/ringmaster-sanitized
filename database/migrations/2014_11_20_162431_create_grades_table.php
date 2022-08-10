<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('grades', function($table)
	    {
	        $table->increments('id');
	        $table->string('grade')->nullable();
	        $table->string('comment')->nullable();

	        $table->integer('assignment_id');
	        $table->integer('user_id');
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
