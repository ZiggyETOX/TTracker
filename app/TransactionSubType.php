<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionSubType extends Model {
	protected $fillable = ['name'];

	public function transaction() {
		return $this->belongsTo('App\Transaction');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}
}
