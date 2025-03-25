<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjustments extends Model
{
    protected $fillable = [
        'id', 'adjustment', 'rangestart', 'rangeend', 'operation', 'percentage', 'fixedamount'
    ];
}
