<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('description', 500);
			$table->integer('type')->default(0);
			$table->integer('minparticipants')->nullable();
			$table->integer('maxparticipants')->nullable();
			$table->integer('timeslot_id')->index('fk_activities_timeslots_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities');
	}

}
