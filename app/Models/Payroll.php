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
}
