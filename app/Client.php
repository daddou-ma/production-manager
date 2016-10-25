<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['full_name', 'nrc', 'nif', 'na', 'address', 'phone', 'fax'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';


    //
    public function fabrications() {
		return $this->hasMany('App\Fabrication');
	}

	public function deliveries() {
		return $this->hasMany('App\Delivery');
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
