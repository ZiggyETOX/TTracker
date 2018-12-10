<?php

namespace App\Http\Controllers;

use App\Invoice;
use Auth;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$invoices = \Auth::user()
			->invoices()
			->get();

		$transactions = \Auth::user()
			->transactions()
			->get();

		foreach ($invoices as $invoice) {

			$invoice->name_date = date('Y-m', strtotime($invoice->name));
			$invoice->sum_of_transactions = count($invoice->transactions);

			$income = $transactions
				->where('invoice_id', $invoice->id)
				->where('type', 'income')
				->sum('amount');
			$expense = $transactions
				->where('invoice_id', $invoice->id)
				->where('type', 'expense')
				->sum('amount');

			$invoice->change = $income - $expense;
		}

		$invoices = $invoices->sortBy('name_date');
		$return['invoices'] = $invoices;

		return view('/invoices/invoicesOverview', $return);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		// $product = new \App\Product;
		// $product->name = 'Ettiene';
		// $product->save();
		return view('/invoices/createform');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	13:24:56.0 UTC (+00:00)
	 */
	public function show(Invoice $invoice) {

		$mydate = $invoice->name . "-00 23:59:59";
		$date = date_create_from_format("Y-F-d H:i:s", $mydate);
		$income = 0;
		$expense = 0;

		$income = \Auth::user()
			->transactions()
			->where('date', '<', $date)
			->where('type', "income")
			->sum('amount');

		$expense = \Auth::user()
			->transactions()
			->where('date', '<', $date)
			->where('type', "expense")
			->sum('amount');

		$balance = $income - $expense;
		$return['balance'] = $balance;
		$transactions = \App\Invoice::find($invoice->id)->transactions;

		$return['transactions'] = $transactions->sortBy('date');
		$return['user'] = \Auth::user();
		$return['downloadType'] = $invoice->name;

		return view('/transactions/transactionOverview', $return);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Invoice $invoice) {

		// $return['invoices'] = \App\Invoice::all();
		// return view('/invoices/editform', $return);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Invoice $invoice) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Invoice $invoice) {
		//
	}
}
