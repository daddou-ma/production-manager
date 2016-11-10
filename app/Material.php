<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    //
    protected $fillable = ['id','name', 'quantity', 'unite_price'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';

    public function products() {
		//return $this->hasMany('App\Component');
		return $this->belongsToMany('App\Product', 'material_product')
		->withPivot('quantity');
	}

	public function commands() {
		return $this->belongsToMany('App\Command', 'material_command')
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
