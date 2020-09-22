<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    
    public function category() 
    {
        return $this->belongsTo(Category::class, 'category_id'); 
    }
    public function company() 
    {
        return $this->belongsTo(Company::class, 'company_id'); 
    }
    public function unit() 
    {
        return $this->belongsTo(Unit::class, 'unit_id'); 
    }
}
