<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoftDeleteAllTheThings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('assignment_submissions', function($table) {
			$table->softDeletes();
		});
		Schema::table('assignments', function($table) {
			$table->softDeletes();
		});
		Schema::table('classroom_user', function($table) {
			$table->softDeletes();
		});
		Schema::table('classrooms', function($table) {
			$table->softDeletes();
		});
		Schema::table('department_user', function($table) {
			$table->softDeletes();
		});
		Schema::table('departments', function($table) {
			$table->softDeletes();
		});
		Schema::table('events', function($table) {
			$table->softDeletes();
		});
		Schema::table('extras', function($table) {
			$table->softDeletes();
		});
		Schema::table('grades', function($table) {
			$table->softDeletes();
		});
		Schema::table('posts', function($table) {
			$table->softDeletes();
		});
		Schema::table('uploads', function($table) {
			$table->softDeletes();
		});
		Schema::table('users', function($table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
