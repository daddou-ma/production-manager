<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialProduct extends Model
{
    //
	public function material() {
		//return $this->belongsTo('App\Material');
		return $this->belongsToMany('App\Material', 'material_product');
	}

	public function product() {
		return $this->belongsToMany('App\Product', 'material_product');
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
