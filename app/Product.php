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
