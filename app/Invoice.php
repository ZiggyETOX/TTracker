<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {

	protected $fillable = ['name'];

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function transactions() {
		return $this->hasMany('App\Transaction');
	}
}
