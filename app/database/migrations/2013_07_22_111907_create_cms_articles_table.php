<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_articles', function($table){
			$table->increments('id');
			$table->string('title');
			$table->longText('summary');
			$table->longText('content');
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
		Schema::drop('cms_articles');
	}

}