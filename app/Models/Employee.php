<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'contact', 'hire_date', 'department_id', 'position_id', 'status', 'department', 'position', 'age', 'gender'
    ];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function deductions()
    {
        return $this->hasMany(Deduction::class);
    }

    public function bonuses()
    {
        return $this->hasMany(Bonus::class);
    }

}
