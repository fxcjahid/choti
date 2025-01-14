<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategories extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('user_id')->unsigned();
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('slug')->unique();
			$table->integer('position')->unsigned()->nullable();
			$table->boolean('is_active')->default(0);
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('categories');
	}
}