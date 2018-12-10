<?php

namespace App\Http\Controllers;

use App\group;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Mail\UserToGroup;
use App\otp;
use App\User;
use App\users;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$groups = \Auth::user()->groups;
		// $users = \App\group::find($groups[0]->id)->users;
		// dd(count($users));
		foreach ($groups as $group) {

			$group->sum_of_users = count($group->users);
		}
		$groups = $groups->sortByDesc('status');
		$return['groups'] = $groups;
		// dd($return);

		return view('/groups/groupsOverview', $return);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

		$return['auth'] = \Auth::user();
		return view('/groups/createform', $return);
	}

	public function otp($otp) {

		$user = \Auth::user();
		$role = 0;
		$select = \App\Otp::where('pin', $otp)
			->where('status', 'pending')
			->first();

		if ($select == null) {

			return redirect('/groups')->with(['message' => 'This Link is wrong. Please try to join a group again.', 'message_header' => 'Submission Unsuccessful']);
		} else {

			if ($select->email == $user->email) {

				$role = 1;
			}

			$check = DB::table('group_user')->insert(
				['role' => $role, 'user_id' => $user->id, 'group_id' => $select->group_id]
			);

			$group = \App\group::find($select->group_id);
			$group->status = 1;
			$group->save();

			$select->status = 'completed';
			$select->save();

			return redirect('/groups/' . $group->id)->with(['message' => 'You have successfully joined this group.', 'message_header' => 'Submission Unsuccessful']);
		}
	}

	public function groupInvite($group_id) {

		$group = \App\group::find($group_id);
		$return['group'] = $group;

		$return['user'] = \Auth::user();

		return view('/groups/inviteGroup', $return);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function groupInviteSend(Request $request, $group_id) {

		$email = $request->input('email');
		$message = $request->input('message');

		$this->myMailingFunction($group_id, $email, $message);

		$groups = \Auth::user()
			->groups;

		foreach ($groups as $group) {

			$group->sum_of_users = count($group->user);
		}
		$return['groups'] = $groups;

		return view('/groups/groupsOverview', $return)->with(['message' => 'Group Created. Please let your friend check his mail at' . $email, 'message_header' => 'Submission Unsuccessful']);

	}

	public function myMailingFunction($group_id, $email, $message) {
		$group = \App\group::find($group_id);
		$user = \Auth::user();

		$one_time_pin = $this->generateRandomString();

		$otp = new \App\Otp;
		$otp->pin = $one_time_pin;
		$otp->status = "pending";
		$otp->email = $email;
		$otp->group_id = $group->id;
		$otp->user_id = $user->id;
		$otp->save();

		$return['groupinfo'] = ['name' => $group->name, 'description' => $message, 'pin' => $one_time_pin, 'from' => $user->name, 'url' => 'http://laravel.local/groups'];

		Mail::to($email)
			->send(new UserToGroup($return));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$groupExist = \App\group::where('name', $request->name)->first();

		if ($groupExist == null) {

			$group = new \App\group;
			$group->name = $request->name;
			$group->description = $request->description;
			$group->status = 0;
			$group->save();
		} else {
			return redirect('/groups/create')->with(['message' => 'Name of group in use. Please try to submit again.', 'message_header' => 'Submission Unsuccessful']);
		}

		$user = \Auth::user();
		$message = 'You created a Group. CLick here to verify and join the group';
		$this->myMailingFunction($group->id, $user->email, $message);

		$groups = \Auth::user()
			->groups;

		foreach ($groups as $group) {

			$group->sum_of_users = count($group->user);
		}
		$return['groups'] = $groups;

		return view('/groups/groupsOverview', $return)->with(['message' => 'Group Created. Please check your emails at ' . $user->email, 'message_header' => 'Submission Unsuccessful']);
	}

	function generateRandomString($length = 24) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function show(group $group) {

		$return['group'] = $group;
		$users = $group->users;
		$return['users'] = $users;
		$invoices = null;
		$invoices = \App\Invoice::whereIn('user_id', $group->users()->pluck('users.id'))
			->distinct()
			->get();
		$transactions = \App\Transaction::whereIn('invoice_id', $invoices->pluck('id')->toArray())->get();
		$income = $transactions->where('type', 'income')->sum('amount');
		$expense = $transactions->where('type', 'expense')->sum('amount');
		$return['groupBalance'] = $income - $expense;

		foreach ($transactions as $transaction) {

			$mydate = $transaction->date;
			$mydate = date('Y-m', strtotime($mydate));
			$transaction->month_date = $mydate;

		}

		$myBalance = 0;
		foreach ($invoices as $invoice) {

			$invoice->name_date = date('Y-m', strtotime($invoice->name));

			$transactionsIncome = $transactions
				->where('type', 'income')
				->where('month_date', '<', $invoice->name_date)
				->sum('amount');

			$transactionsExpense = $transactions
				->where('type', 'expense')
				->where('month_date', '<', $invoice->name_date)
				->sum('amount');

			$income = $transactions
				->where('month_date', $invoice->name_date)
				->where('type', 'income')
				->sum('amount');
			$expense = $transactions
				->where('month_date', $invoice->name_date)
				->where('type', 'expense')
				->sum('amount');
			// dd($transactionsExpense);
			$invoice->change = $income - $expense;
			$invoice->balance = $transactionsIncome - $transactionsExpense + $invoice->change;
		}
		//dd($invoices);

		$invoices = $invoices->sortBy('name_date');
		$return['invoices'] = $invoices->unique('name_date');
		// dd($return);

		// 	$invoices = \App\invoice::
		// 		$return['invoices'] = $invoices;

		return view('/groups/displayGroup', $return);
	}

	public function groupTransactions($group_id, $date) {

		$group = \App\group::where('id', $group_id)->first();

		$invoices = null;
		$invoices = \App\Invoice::whereIn('user_id', $group->users()->pluck('users.id'))
			->distinct()
			->get();
		$transactions = \App\Transaction::whereIn('invoice_id', $invoices->pluck('id')->toArray())
			->get();

		foreach ($transactions as $transaction) {

			$mydate = $transaction->date;

			$mydate = date('Y-F', strtotime($mydate));
			$transaction->month_date = $mydate;
			$invoice = \App\Invoice::find($transaction->invoice_id);
			$user = \App\User::find($invoice->user_id);
			$transaction->owner = $user->name;
		}

		$return['transactions'] = $transactions->where('month_date', $date)->sortBy('date');

		$invoice = \App\Invoice::where('name', $date)->first();

		$invoice->name_date = date('Y-m', strtotime($invoice->name));
		$transactionsIncome = $transactions
			->where('type', 'income')
			->where('month_date', '>', $date)
			->sum('amount');

		$transactionsExpense = $transactions
			->where('type', 'expense')
			->where('month_date', '>', $date)
			->sum('amount');

		$income = $transactions
			->where('month_date', $date)
			->where('type', 'income')
			->sum('amount');
		$expense = $transactions
			->where('month_date', $date)
			->where('type', 'expense')
			->sum('amount');

		$invoice->change = $income - $expense;
		$invoice->myBalance = $transactionsIncome - $transactionsExpense;
		$invoice->balance = $invoice->myBalance + $invoice->change;

		$return['invoice'] = $invoice;
		$return['group'] = $group;
		// dd($return);

		return view('/groups/transactionOverviewGroups', $return);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function edit(group $group) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, group $group) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\group  $group
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(group $group) {
		//
	}
}
