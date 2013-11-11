<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsPagesHasArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_pages_has_articles' , function($table)
		{
			$table->integer('cms_page_id');
			$table->integer('cms_article_id');
			$table->smallInteger('sort_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_pages_has_articles');
	}

}