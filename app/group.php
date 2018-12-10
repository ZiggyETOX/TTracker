<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group extends Model {
	//

	public function users() {
		return $this->belongsToMany('App\User');
	}
}
