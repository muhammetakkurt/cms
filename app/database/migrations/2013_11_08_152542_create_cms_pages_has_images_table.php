<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsPagesHasImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_pages_has_images', function($table){
			$table->integer('cms_media_id');
			$table->integer('cms_page_id');
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
		Shema::drop('cms_pages_has_images');
	}

}