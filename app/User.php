<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'balance', 'name', 'email', 'password', 'role',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function groups() {
		return $this->belongsToMany('App\group');
	}

	public function invoices() {
		return $this->hasMany('App\Invoice');
	}

	public function transactions() {
		return $this->hasManyThrough('App\Transaction', 'App\Invoice');
	}

	public function transaction_sub_type() {
		return $this->hasMany('App\TransactionSubType');
	}
}
