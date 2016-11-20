<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //

    protected $fillable = ['client_id', 'delivery_date', 'count_products', 'delivery_date', 'total_notax', 'taux_douane', 'total_price', 'state'];
	protected $guarded = [];
	
	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';
	

    public function client() {
		return $this->belongsTo('App\Client');
	}

	public function products() {
		//return $this->hasMany('App\Component');
		return $this->belongsToMany('App\Product', 'product_delivery')
		->withPivot('quantity', 'unite_price', 'price');	
	}

	public function scopeOnlyActif($query, $actif)
	{
		if ($actif) {
			return $query->where('actif', true);
		}
	    return $query;
	}

	public function scopeOrdered($query, $actif)
	{
	    if ($this->orderBy)
	    {
	        return $query->onlyActif($actif)->orderBy($this->orderBy, $this->orderDirection);
	    }

	    return $query;
	}
}
