<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'cycle_id',
        'base_pay',
        'gross_pay',
        'net_pay',
        'adjustments_total',
        'hours_worked',
        'pdf_path',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }
        public function payrollAdjustments()
    {
        return $this->hasMany(PayrollAdjustment::class);
    }
}
