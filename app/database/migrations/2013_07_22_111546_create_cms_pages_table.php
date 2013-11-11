<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_pages', function($table){
			$table->increments('id');
			$table->integer('parent_id');
			$table->string('name');
			$table->smallInteger('sort_order');
			$table->dateTime('published_on')->nullable();
		    $table->dateTime('published_off')->nullable();
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
		Schema::drop('cms_pages');
	}

}