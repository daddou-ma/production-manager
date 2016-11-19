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
		->withPivot('quantity','unite_price','mantant_facture','pret','taux_euro','euro_dinars','taux_dinars','taux_douane','transit_fees','taux_achat','calculed_price');
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
