<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
	protected $fillable = ['full_name', 'nrc', 'nif', 'na', 'address', 'phone', 'fax'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';

    //
    public function commands() {
		return $this->hasMany('App\Command');
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
