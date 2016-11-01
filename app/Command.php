<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{

	protected $fillable = ['full_name', 'nrc', 'nif', 'na', 'address', 'phone', 'fax'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';
	
    //

    public function materials() {
		//return $this->hasMany('App\ProductMaterial');
		return $this->belongsToMany('App\Material', 'material_command')
		->withPivot('quantity');
	}

    public function provider() {
		return $this->belongsto('App\Provider');
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
