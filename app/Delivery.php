<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //
    public function client() {
		return $this->belongsTo('App\Client');
	}

	public function products() {
		//return $this->hasMany('App\Component');
		return $this->belongsToMany('App\Product', 'product_delivery')
		->withPivot('quantity');
	}

	public function scopeOrdered($query)
	{
	    if ($this->orderBy)
	    {
	        return $query->orderBy($this->orderBy, $this->orderDirection);
	    }

	    return $query;
	}
}
