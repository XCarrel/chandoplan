<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeslotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeslots', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->time('from');
            $table->boolean('mandatory')->default(0);
			$table->time('to');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timeslots');
	}

}
