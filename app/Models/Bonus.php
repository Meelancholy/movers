<?php

// app/Models/Bonus.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
        'employee_id',
        'bonus_name',
        'amount',
        'frequency',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

