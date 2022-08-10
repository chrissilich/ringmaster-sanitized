<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploads', function($table)
	    {
	        $table->increments('id');
	        $table->string('name')->nullable();
	        $table->string('filename');
	        $table->integer('owner_id');

	        $table->integer('belongs_to_id');
	        $table->string('belongs_to_type');
	        $table->string('upload_kind');
	        
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
		Schema::drop('uploads');
	}

}
