<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabrication extends Model
{
    //
    public function client() {
		return $this->belongsTo('App\Client');
	}

	public function product() {
		return $this->belongsTo('App\Product');
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
