<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Excel;
use App\Exports\transactionsExport;
use App\Invoice;
use App\Transaction;
use App\TransactionSubType;
use Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// use App\Http\Controllers\Controller;

class TransactionController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$balance = 0;
		$return['balance'] = $balance;

		$transactions = \Auth::user()->transactions;

		$transactions = $transactions->sortBy('date');

		$return['transactions'] = $transactions;
		$return['user'] = \Auth::user();
		$return['downloadType'] = 'all';

		return view('/transactions/transactionOverview', $return);

	}

	public function export($type, $id, $date_name) {

		if ($type == "user") {

			$transactions = \App\User::find($id)->transactions;
		} else {

			$group = \App\group::where('id', $id)->first();

			$invoices = null;
			$invoices = \App\Invoice::whereIn('user_id', $group->users()->pluck('users.id'))
				->distinct()
				->get();
			$transactions = \App\Transaction::whereIn('invoice_id', $invoices->pluck('id')->toArray())
				->get();

		}

		foreach ($transactions as $transaction) {

			$invoice = \App\Invoice::find($transaction->invoice_id);
			$user = \App\User::find($invoice->user_id);
			$transaction->owner = $user->name;
		}

		if ($date_name == "all") {

			$transactions = $transactions;
		} else {

			foreach ($transactions as $transaction) {

				$mydate = $transaction->date;
				$mydate = date('Y-F', strtotime($mydate));
				$transaction->month_date = $mydate;
			}

			$transactions = $transactions->where('month_date', $date_name);
		}

		return Excel::download(new transactionsExport($transactions), 'Transactions_FROM_' . $date_name . '.xlsx');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$return['expensesubtypes'] = \App\TransactionSubType::where('type', 'expense')
			->where('user_id', Auth::id())
			->get();
		$return['incomesubtypes'] = \App\TransactionSubType::where('type', 'income')
			->where('user_id', Auth::id())
			->get();
		$return['user'] = Auth::user();
		// dd($return);
		return view('/transactions/createform', $return);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$transaction = new \App\Transaction;
		foreach ($request->all() as $key => $value) {

			switch ($key) {
			case 'name':
			case 'date':
			case 'type':
			case 'description':
			case 'amount':
			case 'pb':
				$transaction->$key = $value;
				break;

			default:
				# code...
				break;
			}
		}
		if ($request->input('type') == "income") {

			$user = Auth::user();
			$user->balance += $request->input('amount');
			$user->save();

		} else {

			$user = Auth::user();
			$user->balance -= $request->input('amount');
			$user->save();

		}

		$date = $request->input('date');
		$name = date('Y-F', strtotime($date));
		$userID = Auth::id();
		$invoice = \App\Invoice::where('name', $name)->where('user_id', $userID)->first();

		if ($invoice == null) {
			$invoiceCreate = new \App\Invoice;
			$invoiceCreate->name = $name;
			$invoiceCreate->user_id = $userID;
			$invoiceCreate->save();
			$transaction->invoice_id = $invoiceCreate->id;
		} else {
			$transaction->invoice_id = $invoice->id;
		}

		if ($request->input('sellectSubType') == "other") {

			$name = $request->input('subtype');
			$type = $request->input('type');

			$transactionSubType = \App\TransactionSubType::where(
				'name', $name)
				->where('type', $type)
				->where('user_id', Auth::id())
				->first();

			if ($transactionSubType == null) {
				$transactionSubTypeCreate = new \App\TransactionSubType;
				$transactionSubTypeCreate->name = $name;
				$transactionSubTypeCreate->type = $type;
				$transactionSubTypeCreate->user_id = $userID;
				$transactionSubTypeCreate->save();
				$transaction->transaction_sub_types_id = $transactionSubTypeCreate->id;
			} else {
				$transaction->transaction_sub_types_id = $transactionSubType->id;
			}

			$transaction->save();
			return redirect('/invoices');

		} else {
			if (empty($request->input('subtype'))) {
				return redirect('/transactions/create')->with(['message' => 'There was a problem with adding your transaction. Please try to submit again.', 'message_header' => 'Submission Unsuccessful']);
			} else {
				$transaction->transaction_sub_types_id = $request->input('subtype');
				$transaction->save();
				return redirect('/invoices');
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function show(Transaction $transaction) {
		$newTransaction = new \App\Transaction;
		//$newTransaction = $transaction;

		foreach ($transaction->toArray() as $key => $value) {

			switch ($key) {
			case 'name':
			case 'date':
			case 'type':
			case 'amount':
			case 'pb':
			case 'description':
			case 'transaction_sub_types_id':
			case 'invoice_id':
				$newTransaction->$key = $value;
				break;

			default:
				# code...
				break;
			}
		}

		$newTransaction->name = $newTransaction->name . " (COPY)";

		if ($transaction->type == "income") {

			$user = Auth::user();
			$user->balance += $transaction->amount;
			$user->save();
		} else {

			$user = Auth::user();
			$user->balance -= $transaction->amount;
			$user->save();
		}

		$newTransaction->save();
		return redirect('/transactions/' . $newTransaction->id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Transaction $transaction) {

		$return['expensesubtypes'] = \App\TransactionSubType::where('type', 'expense')
			->where('user_id', Auth::id())
			->get();
		$return['incomesubtypes'] = \App\TransactionSubType::where('type', 'income')
			->where('user_id', Auth::id())
			->get();
		$return['transaction'] = $transaction;
		//dd($return);
		return view('/transactions/editform', $return);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Transaction $transaction) {
		$Ramount = $request->input('amount');
		$Rtype = $request->input('type');
		$Tamount = ($transaction->amount . "");
		$Ttype = $transaction->type;
		// dd($transaction);
		foreach ($request->all() as $key => $value) {

			switch ($key) {
			case 'name':
			case 'date':
			case 'type':
			case 'description':
			case 'amount':
			case 'pb':
				$transaction->$key = $value;
				break;

			default:
				# code...
				break;
			}
		}

		$date = $request->input('date');
		$name = date('Y-F', strtotime($date));
		$userID = Auth::id();

		$invoice = \App\Invoice::where('name', $name)->where('user_id', $userID)->first();

		if ($invoice == null) {
			$invoiceCreate = new \App\Invoice;
			$invoiceCreate->name = $name;
			$invoiceCreate->user_id = $userID;
			$invoiceCreate->save();
			$transaction->invoice_id = $invoiceCreate->id;
		} else {
			$transaction->invoice_id = $invoice->id;
		}

		if ($request->input('sellectSubType') == "other") {

			$name = $request->input('subtype');
			$type = $request->input('type');

			$transactionSubType = \App\TransactionSubType::where(
				'name', $name)
				->where('type', $type)
				->where('user_id', $userID)
				->first();

			if ($transactionSubType == null) {
				$transactionSubTypeCreate = new \App\TransactionSubType;
				$transactionSubTypeCreate->name = $name;
				$transactionSubTypeCreate->type = $type;
				$transactionSubTypeCreate->user_id = $userID;
				$transactionSubTypeCreate->save();
				$transaction->transaction_sub_types_id = $transactionSubTypeCreate->id;
			} else {
				$transaction->transaction_sub_types_id = $transactionSubType->id;
			}

			$transaction->save();
		} else {
			//check if there is an error with the subtype
			if (empty($request->input('subtype'))) {
				return redirect('/transactions/create')->with(['message' => 'There was a problem with adding your transaction. Please try to submit again.', 'message_header' => 'Submission Unsuccessful']);
			} else {
				$transaction->transaction_sub_types_id = $request->input('subtype');
				$transaction->save();
			}
		}

		//checking if the balance should have changed and then update the user's balance
		if ($Ramount == $Tamount && $Rtype == $Ttype) {

		} else {

			$income = 0;
			$expense = 0;
			$balance = 0;

			$income = \Auth::user()
				->transactions()
				->where('type', "income")
				->sum('amount');

			$expense = \Auth::user()
				->transactions()
				->where('type', "expense")
				->sum('amount');

			$balance = $income - $expense;
			// dd($balance);
			$user = \Auth::user();
			$user->balance = $balance;
			$user->save();
		}

		return redirect('/invoices');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Transaction  $transaction
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Transaction $transaction) {

		$income = 0;
		$expense = 0;
		$balance = 0;
		$invoice_id = $transaction->invoice_id;

		$transaction->delete();

		$income = \Auth::user()
			->transactions()
			->where('type', "income")
			->sum('amount');

		$expense = \Auth::user()
			->transactions()
			->where('type', "expense")
			->sum('amount');

		$balance = $income - $expense;
		$user = \Auth::user();
		$user->balance = $balance;
		$user->save();

		$invoice = \App\Invoice::find($invoice_id);

		if ($invoice->transactions->count() > 0) {

		} else {
			$invoice->delete();
		}

		return redirect('/invoices');
	}
}
