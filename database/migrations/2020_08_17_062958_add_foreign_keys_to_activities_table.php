<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activities', function(Blueprint $table)
		{
			$table->foreign('domain_id', 'fk_activities_domains1')->references('id')->on('domains')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('slot_id', 'fk_activities_slots1')->references('id')->on('slots')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activities', function(Blueprint $table)
		{
			$table->dropForeign('fk_activities_domains1');
			$table->dropForeign('fk_activities_slots1');
		});
	}

}
