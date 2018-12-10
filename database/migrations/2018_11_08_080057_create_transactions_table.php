<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up() {
		Schema::disableForeignKeyConstraints();
		Schema::create('transactions', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->date('date');
			$table->string('type');
			$table->double('amount', 12, 2);
			$table->string('pb');
			$table->longText('description');
			$table->timestamps();

			$table->integer('invoice_id')->unsigned();
			$table->foreign('invoice_id')->references('id')->on('invoices');

			$table->integer('transaction_sub_types_id')->unsigned();
			$table->foreign('transaction_sub_types_id')->references('id')->on('transaction_sub_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('transactions');
	}
}
