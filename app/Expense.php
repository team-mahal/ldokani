<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $guarded = [];

    public function expense_type() 
    {
        return $this->belongsTo(Expensetype::class, 'type_id'); 
    }
    public function service_provider() 
    {
        return $this->belongsTo(Serviceprovider::class, 'provider_id'); 
    }
    public function employee() 
    {
        return $this->belongsTo(Employee::class, 'employee_id'); 
    }
}
