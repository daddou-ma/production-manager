<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialCommand extends Model
{
    //
	public function material() {
		//return $this->belongsTo('App\Material');
		return $this->belongsToMany('App\Material', 'material_command');
	}

	public function command() {
		return $this->belongsToMany('App\Command', 'material_command');
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
