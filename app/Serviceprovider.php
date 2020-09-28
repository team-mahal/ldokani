<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serviceprovider extends Model
{
    use SoftDeletes;
    protected $guarded = [];
}
