<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePages extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->unsignedBigInteger('user_id');
			$table->text('content')->nullable();
			$table->enum('status', ['publish', 'draft', 'trash'])->default('draft');
			$table->string('slug')->unique();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('page');
	}
}
