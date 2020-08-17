<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToSlotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('slots', function(Blueprint $table)
		{
			$table->foreign('timeslot_id', 'fk_slots_timeslots1')->references('id')->on('timeslots')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('slots', function(Blueprint $table)
		{
			$table->dropForeign('fk_slots_timeslots1');
		});
	}

}
