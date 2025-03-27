<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    protected $fillable = [
        'adjustment',
        'rangestart',
        'rangeend',
        'operation',
        'percentage',
        'fixedamount'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)
                    ->withPivot('frequency')
                    ->withTimestamps();
    }

    // Helper method to display adjustment details
    public function getDisplayNameAttribute()
    {
        if ($this->fixedamount) {
            return "{$this->adjustment} (Fixed: {$this->fixedamount})";
        } elseif ($this->percentage) {
            return "{$this->adjustment} ({$this->percentage}%)";
        } else {
            return $this->adjustment;
        }
    }
}
