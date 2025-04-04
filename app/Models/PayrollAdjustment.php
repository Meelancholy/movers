<?php
// app/Models/PayrollAdjustment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollAdjustment extends Model
{
    protected $fillable = [
        'payroll_id',
        'adjustment_id',
        'amount',
        'type',
        'frequency_before',
        'frequency_after',
        'employee_id',
        'adjustment_data'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function adjustment()
    {
        return $this->belongsTo(Adjustment::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getAdjustmentDetailsAttribute()
    {
        if ($this->adjustment) {
            return [
                'adjustment' => $this->adjustment->adjustment,
                'operation' => $this->adjustment->operation,
                'percentage' => $this->adjustment->percentage,
                'fixedamount' => $this->adjustment->fixedamount,
                'rangestart' => $this->adjustment->rangestart,
                'rangeend' => $this->adjustment->rangeend
            ];
        }

        return json_decode($this->adjustment_data, true) ?? [];
    }
}
