<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToActivityUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('activity_user', function(Blueprint $table)
		{
			$table->foreign('activity_id', 'fk_activities_has_users_activities1')->references('id')->on('activities')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('user_id', 'fk_activities_has_users_users1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('activity_user', function(Blueprint $table)
		{
			$table->dropForeign('fk_activities_has_users_activities1');
			$table->dropForeign('fk_activities_has_users_users1');
		});
	}

}
