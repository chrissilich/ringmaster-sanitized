<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddJoinCodeToClassroom extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('classrooms', function(Blueprint $table)
		{
			$table->string('join_code')->nullable();
			$table->unique('join_code');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('classrooms', function(Blueprint $table)
		{
			
		});
	}

}
