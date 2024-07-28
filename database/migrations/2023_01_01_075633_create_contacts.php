<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContacts extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name')->nullable();
			$table->integer('phone')->nullable()->unsigned();
			$table->string('email');
			$table->string('message')->nullable();
			$table->boolean('read')->default(0);
			$table->integer('assign')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('contact');
	}
}