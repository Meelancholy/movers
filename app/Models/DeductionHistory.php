<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'description', 'amount', 'payroll_id'
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
