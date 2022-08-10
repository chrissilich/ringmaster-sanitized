<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveEventsToBelongsToSetup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('events', function($table)
	    {
	    	$table->dropColumn('classroom_id');
	    	$table->dropColumn('department_id');

	    	$table->integer('belongs_to_id');
	        $table->string('belongs_to_type');
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
