<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivations extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activations', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedBigInteger('user_id')->index();
			$table->string('code');
			$table->boolean('completed')->default(false);
			$table->datetime('completed_at')->nullable();
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
		Schema::dropIfExists('activations');
	}
}