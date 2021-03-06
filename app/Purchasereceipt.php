<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchasereceipt extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
    public function distributor() 
    {
        return $this->belongsTo(Distributor::class, 'distributor_id'); 
    }
}
