<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model {

	public function groups() {
		return $this->belongsTo('App\group');
	}

	public function users() {
		return $this->belongsTo('App\User');
	}
}
