<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    //
	public function material() {
		return $this->belongsTo('App\Material');
	}

	public function product() {
		return $this->belongsTo('App\Product');
	}
}
