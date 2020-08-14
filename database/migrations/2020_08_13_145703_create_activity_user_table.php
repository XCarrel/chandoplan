<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivityUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activity_user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('activity_id')->index('fk_activities_has_users_activities1_idx');
			$table->bigInteger('user_id')->unsigned()->index('fk_activities_has_users_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activity_user');
	}

}
