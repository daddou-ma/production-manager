<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{

	protected $fillable = ['provider_id', 'command_date', 'total_price','state'];
	protected $guarded = [];

	protected $orderBy = 'created_at';
	protected $orderDirection = 'DESC';
	
    //

    public function materials() {
		//return $this->hasMany('App\ProductMaterial');
		return $this->belongsToMany('App\Material', 'material_command')
		->withPivot('quantity','unite_price','mantant_facture','pret','taux_euro','euro_dinars','taux_dinars','taux_douane','transit_fees','taux_achat','calculed_price');
	}

    public function provider() {
		return $this->belongsto('App\Provider');
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
