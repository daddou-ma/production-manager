<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //

    protected $fillable = ['client_id', 'delivery_date', 'total_price', 'state'];
	protected $guarded = [];
	
	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';
	

    public function client() {
		return $this->belongsTo('App\Client');
	}

	public function products() {
		//return $this->hasMany('App\Component');
		return $this->belongsToMany('App\Product', 'product_delivery')
		->withPivot('quantity', 'price');
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
