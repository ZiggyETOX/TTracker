<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSubTypesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::disableForeignKeyConstraints();
		Schema::create('transaction_sub_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('type');
			$table->timestamps();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('transaction_sub_types');
	}
}
