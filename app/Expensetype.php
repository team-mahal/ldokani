<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expensetype extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
