<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $primaryKey = 'position_id'; // Define custom primary key

    protected $fillable = ['position_name', 'department_id', 'base_salary'];

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
