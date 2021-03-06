<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sells', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('price');
			$table->string('title');
			$table->text('discription');
			$table->string('condition')->nullable();
			$table->string('type');
			$table->string('author');
			$table->string('degree_name');
			$table->string('image_1');
			$table->string('image_2')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('sells');
	}
}
