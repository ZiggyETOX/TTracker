<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
	protected $fillable = [
		'user_id', 'name',
	];

	public function invoice() {
		return $this->belongsTo('App\Invoice');
	}

	public function transaction_sub_type() {
		return $this->belongsTo('App\TransactionSubType', 'transaction_sub_types_id');
	}
}
