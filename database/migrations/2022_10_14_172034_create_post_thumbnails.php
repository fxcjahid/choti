<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostThumbnails extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_thumbnails', function (Blueprint $table) {
			$table->integer('post_id')->unsigned();
			$table->integer('file_id')->unsigned();

			$table->primary(['post_id', 'file_id']);
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('post_thumbnail');
	}
}