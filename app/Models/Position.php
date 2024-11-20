<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name', 'department_id', 'base_salary'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
