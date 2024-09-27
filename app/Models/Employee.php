<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'position_id',
        'hire_date',
        'status',
        'contact_info',
        'address'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'position_id');
    }
}
