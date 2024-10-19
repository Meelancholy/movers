<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'payrolls';

    // Define the fillable attributes
    protected $fillable = [
        'employee_id',
        'salary',
        'gross_salary',
        'withholdings',
        'net_salary',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function bonuses()
    {
        return $this->belongsToMany(Bonus::class, 'payroll_bonus')
                    ->withPivot('amount')
                    ->withTimestamps();
    }

    public function deductions()
    {
        return $this->belongsToMany(Deduction::class, 'payroll_deduction')
                    ->withPivot('amount')
                    ->withTimestamps();
    }
    public function bonusHistories()
    {
        return $this->hasMany(BonusHistory::class);
    }
    public function deductionHistories()
    {
        return $this->hasMany(BonusHistory::class);
    }
}
