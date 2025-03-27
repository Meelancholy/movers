<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee_salary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'hourly_rate',
        'monthly_salary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'monthly_salary' => 'decimal:2',
    ];

    /**
     * Get the employee associated with the salary record.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
