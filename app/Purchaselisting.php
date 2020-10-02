<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchaselisting extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function distributor() 
    {
        return $this->belongsTo(Distributor::class, 'distributor_id'); 
    }

    public function purchasereceipt() 
    {
        return $this->belongsTo(Purchasereceipt::class, 'purchasereceipt_id'); 
    }

    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id'); 
    }
}
