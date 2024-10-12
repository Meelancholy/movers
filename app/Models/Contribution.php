<?php

// app/Models/Contribution.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'philhealth', 'sss', 'pagibig', 'custom_contribution_name', 'custom_contribution_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
