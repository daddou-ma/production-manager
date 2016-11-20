<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'quantity', 'unite_price'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';

    public function materials() {
		//return $this->hasMany('App\ProductMaterial');
		return $this->belongsToMany('App\Material', 'material_product')
		->withPivot('quantity');
	}

	public function fabrications() {
		return $this->hasMany('App\Fabrication');
	}

	public function deliveries() {
		//return $this->hasMany('App\Component');
		return $this->belongsToMany('App\Delivery', 'product_delivery')
		->withPivot('quantity', 'unite_price','price');	
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
