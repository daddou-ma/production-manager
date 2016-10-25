<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    //
    public function provider() {
		return $this->belongsto('App\Provider');
	}

	public function material() {
		return $this->belongsTo('App\Material');
	}
}
