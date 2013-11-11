<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsArticlesHasImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_articles_has_images', function($table){
			$table->integer('cms_media_id');
			$table->integer('cms_article_id');
			$table->integer('sort_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cms_articles_has_images');
	}

}