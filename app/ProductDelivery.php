<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDelivery extends Model
{
    //

    public function product() {
		//return $this->hasMany('App\ProductMaterial');
		return $this->belongsToMany('App\Product', 'product_delivery');
	}


	public function delivery() {
		return $this->belongsToMany('App\Delivery', 'product_delivery');
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
