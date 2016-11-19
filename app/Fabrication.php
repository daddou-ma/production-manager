<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabrication extends Model
{
    //

    protected $fillable = ['product_id', 'fabrication_date', 'quantity', 'progress', 'stats', 'actif'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';

    public function client() {
		return $this->belongsTo('App\Client');
	}

	public function product() {
		return $this->belongsTo('App\Product');
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
