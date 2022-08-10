<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveClassroomApprovalAddClassroomRole extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	
		Schema::table('classroom_user', function(Blueprint $table)
		{
			$table->string('role');
			$table->dropColumn('approved');
		});

		$classes = Classroom::all();
		foreach ($classes as $c) {
			$c->users()->attach($c->owner_id, array('role' => 'creator'));
		}			

		Schema::table('classrooms', function(Blueprint $table)
		{
			$table->dropColumn('owner_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	}

}
