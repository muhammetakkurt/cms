<?php

use Illuminate\Database\Migrations\Migration;

class CreateCmsArticleCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_article_comments', function($table){
			$table->increments('id');
			$table->integer('article_id');
			$table->integer('author_id')->nullable();
			$table->string('author_name')->nullable();
			$table->boolean('status');
			$table->LongText('comment');
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
		Schema::drop('cms_article_comments');
	}

}