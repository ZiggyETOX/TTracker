<?php

namespace App\Exports;

use App\Transaction;
use App\TransactionSubType;
use Maatwebsite\Excel\Concerns\FromCollection;

class transactionsExport implements FromCollection {

	public function __construct($transactions) {

		$myTransactionHeaders = array(
			'date' => 'Date',
			'name' => 'Transaction By',
			'type' => 'Income/Expense',
			'transaction_sub_types_id' => 'SubType',
			'amount' => 'Price',
			'pb' => 'Personal/Business',
			'description' => 'Description');

		$mytransactions = array($myTransactionHeaders);

		foreach ($transactions as $transaction) {

			$subtype = \App\TransactionSubType::find($transaction->transaction_sub_types_id);

			$myTransaction = array(
				'date' => $transaction->date,
				'name' => $transaction->name,
				'type' => $transaction->type,
				'transaction_sub_types_id' => $subtype->name,
				'amount' => $transaction->amount,
				'pb' => $transaction->pb,
				'description' => $transaction->description);
			array_push($mytransactions, $myTransaction);
		}
		$this->transactions = collect($mytransactions);
	}

	/**
	 * @param  \App\Transaction  $transactions
	 * @return \Illuminate\Support\Collection
	 */
	public function collection() {

		return $this->transactions;
	}
}
