<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
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
